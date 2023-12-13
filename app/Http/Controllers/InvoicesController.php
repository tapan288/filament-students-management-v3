<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;

class InvoicesController extends Controller
{
    public function generatePdf(Student $student)
    {
        $student = new Buyer([
            'name' => $student->name,
            'custom_fields' => [
                'email' => $student->email,
            ],
        ]);

        $item = InvoiceItem::make('Service 1')->pricePerUnit(2);

        $invoice = Invoice::make()
            ->buyer($student)
            ->discountByPercent(10)
            ->taxRate(15)
            ->shipping(1.99)
            ->addItem($item);

        return $invoice->stream();
    }
}
