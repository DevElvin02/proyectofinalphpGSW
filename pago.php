<?php
session_start();
require 'vendor/autoload.php';

use PayPal\Api\Payer;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;

// Configuración de PayPal
$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        'ATpQCFunhYqP_ZOYZD_sNDSwyq4vU8Fe4sIP-dr9ZG5ZRNdN3japOHCx1pd2jd9Q37eMXT2W2sjNGk7W', // Sustituye con tu Client ID
        'EBy41lmKUwenBDylhThG_AlEveC6KlE-ToNh2edKj0u1StKtVl4GjUDfBDjLIaTLgqyfQG88MLnjODGJ' // Sustituye con tu Client Secret
    )
);

if (!empty($_SESSION['carrito'])) {
    $payer = new Payer();
    $payer->setPaymentMethod("paypal");

    $items = [];
    $total = 0;

    foreach ($_SESSION['carrito'] as $producto) {
        $item = new Item();
        $item->setName($producto['name'])
             ->setCurrency('USD')
             ->setQuantity($producto['cantidad'])
             ->setPrice($producto['price']);
        $items[] = $item;
        $total += $producto['price'] * $producto['cantidad'];
    }

    $itemList = new ItemList();
    $itemList->setItems($items);

    $amount = new Amount();
    $amount->setCurrency("USD")->setTotal($total);

    $transaction = new Transaction();
    $transaction->setAmount($amount)
                ->setItemList($itemList)
                ->setDescription("Compra en Sublimart");

    $redirectUrls = new RedirectUrls();
    $redirectUrls->setReturnUrl("http://localhost/exito.php")
                 ->setCancelUrl("http://localhost/cancelado.php");

    $payment = new Payment();
    $payment->setIntent("sale")
            ->setPayer($payer)
            ->setTransactions([$transaction])
            ->setRedirectUrls($redirectUrls);

    try {
        $payment->create($apiContext);
        header("Location: " . $payment->getApprovalLink());
        exit();
    } catch (Exception $e) {
        die($e->getData());
    }
}
?>