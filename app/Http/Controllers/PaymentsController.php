<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Products;
use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use MercadoPago\InstoreOrder;
use MercadoPago\Item;
use MercadoPago\Preference;
use MercadoPago\SDK;
use PayPal\Api\Payer;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

class PaymentsController extends Controller
{
    private $apiContext;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('auth.client');
        $paypalConfig = Config::get('paypal');
        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                $paypalConfig['client_id'],
                $paypalConfig['secret']
            )
        );
        SDK::setAccessToken(config('mercadopago.access_token'));
    }

    public function index()
    {
        $id_user = auth()->user()->id;
        $carts = Cart::where('fk_user', '=', $id_user)->sum('amount');
        $products = Products::join('categories', 'categories.id', '=', 'products.fk_category')
            ->join('carts', 'carts.fk_product', '=', 'products.id')
            ->select('products.*', 'categories.category', 'carts.amount')
            ->where('products.state', '=', 'Activo')
            ->where('products.stock', '>', 0)
            ->where('carts.fk_user', '=', $id_user)
            ->orderBy('products.name', 'asc')
            ->get();
        $total = 0;
        foreach ($products as $item) {
            $total += ($item->amount * $item->price);
        }
        return view('payments.payments', compact('carts', 'total'));
    }

    public function paypal()
    {
        $id_user = auth()->user()->id;
        $carts = Cart::where('fk_user', '=', $id_user)->sum('amount');
        if ($carts > 0) {
            $products = Products::join('categories', 'categories.id', '=', 'products.fk_category')
                ->join('carts', 'carts.fk_product', '=', 'products.id')
                ->select('products.*', 'categories.category', 'carts.amount')
                ->where('products.state', '=', 'Activo')
                ->where('products.stock', '>', 0)
                ->where('carts.fk_user', '=', $id_user)
                ->orderBy('products.name', 'asc')
                ->get();
            $total = 0;
            foreach ($products as $item) {
                $total += ($item->amount * $item->price);
            }
            $dolar = 0;
            $url = 'https://api.cambio.today/v1/full/USD/json?key=46107|seyrH1md2SYjoavaYni6';
            $file = file_get_contents($url);
            $data = json_decode($file, true);
            $conversion = $data['result']['conversion'];
            foreach ($conversion as $item) {
                if ($item['to'] == 'COP') {
                    $dolar = $item['rate'];
                }
            }
            $usd_total = $total / $dolar;
            $payer = new Payer();
            $payer->setPaymentMethod('paypal');
            $amount = new Amount();
            $amount->setTotal($usd_total);
            $amount->setCurrency('USD');
            $transaction = new Transaction();
            $transaction->setAmount($amount);
            $callbackUrl = url('/paypal/paypal_status');
            $redirectUrls = new RedirectUrls();
            $redirectUrls->setReturnUrl($callbackUrl)
                ->setCancelUrl($callbackUrl);
            $payment = new Payment();
            $payment->setIntent('sale')
                ->setPayer($payer)
                ->setTransactions(array($transaction))
                ->setRedirectUrls($redirectUrls);
            try {
                $payment->create($this->apiContext);
                return redirect()->away($payment->getApprovalLink());
            } catch (PayPalConnectionException $ex) {
                echo $ex->getData();
            }
        } else {
            return redirect()->route('catalog.index');
        }
    }

    public function paypal_status(Request $request)
    {
        $payment_id = $request->input('paymentId');
        $payer_id = $request->input('PayerID');
        $token = $request->input('token');
        if (!$payment_id || !$payer_id || !$token) {
            return redirect()->route('payments.index')->with('danger', 'El pago a través de Paypal no se pudo realizar.');
        }
        $payment = Payment::get($payment_id, $this->apiContext);
        $execution = new PaymentExecution();
        $execution->setPayerId($payer_id);
        $result = $payment->execute($execution, $this->apiContext);
        if ($result->getState() == 'approved') {
            $id_user = auth()->user()->id;
            $carts = Cart::select()->where('fk_user', '=', $id_user)->get();
            foreach ($carts as $item) {
                $sales = new Sales;
                $sales->fk_product = $item->fk_product;
                $sales->fk_user = $item->fk_user;
                $sales->amount = $item->amount;
                $sales->invoice = $payment_id;
                $sales->save();
                $products = Products::find($item->fk_product);
                $stock = $products->stock - $item->amount;
                Products::where('id', '=', $item->fk_product)->update(['stock' => $stock]);
                Cart::where('id', '=', $item->id)->delete();
            }
            return redirect()->route('payments.index')->with('success', 'El pago a través de PayPal se ha realizado correctamente.');
        }
        return redirect()->route('payments.index')->with('danger', 'El pago a través de Paypal no se pudo realizar.');
    }

    public function mercadopago()
    {
        $id_user = auth()->user()->id;
        $carts = Cart::where('fk_user', '=', $id_user)->sum('amount');
        if ($carts > 0) {
            $products = Products::join('categories', 'categories.id', '=', 'products.fk_category')
                ->join('carts', 'carts.fk_product', '=', 'products.id')
                ->select('products.*', 'categories.category', 'carts.amount')
                ->where('products.state', '=', 'Activo')
                ->where('products.stock', '>', 0)
                ->where('carts.fk_user', '=', $id_user)
                ->orderBy('products.name', 'asc')
                ->get();
            $total = 0;
            foreach ($products as $item) {
                $total += ($item->amount * $item->price);
            }
            $preference = new Preference();
            $item = new Item();
            $item->title = 'Productos (' . $carts . ')';
            $item->quantity = 1;
            $item->unit_price = $total;
            $preference->items = array($item);
            $preference->back_urls = array(
                'success' => route('mercadopago.mp_status'),
                'failure' => route('mercadopago.mp_status'),
            );
            $preference->auto_return = 'approved';
            $preference->save();
            return redirect()->to($preference->init_point);
        } else {
            return redirect()->route('catalog.index');
        }
    }

    public function mp_status(Request $request)
    {
        $payment_id = $request->get('payment_id');
        $response = Http::get('https://api.mercadopago.com/v1/payments/' . $payment_id . '?access_token=' . config('mercadopago.access_token'));
        $response = json_decode($response);
        if (!empty($response->error)) {
            return redirect()->route('payments.index')->with('danger', 'El pago a través de MercadoPago no se pudo realizar.');
        } else {
            if ($response->status == 'approved') {
                $id_user = auth()->user()->id;
                $carts = Cart::select()->where('fk_user', '=', $id_user)->get();
                foreach ($carts as $item) {
                    $sales = new Sales;
                    $sales->fk_product = $item->fk_product;
                    $sales->fk_user = $item->fk_user;
                    $sales->amount = $item->amount;
                    $sales->invoice = $payment_id;
                    $sales->save();
                    $products = Products::find($item->fk_product);
                    $stock = $products->stock - $item->amount;
                    Products::where('id', '=', $item->fk_product)->update(['stock' => $stock]);
                    Cart::where('id', '=', $item->id)->delete();
                }
                return redirect()->route('payments.index')->with('success', 'El pago a través de MercadoPago se ha realizado correctamente.');
            }
        }
    }
}