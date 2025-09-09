<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Mike42\Escpos\Printer;
use Illuminate\Http\Request;
use App\Models\Printer as PrinterConfig;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;

class PrinterController extends Controller
{
    public function ticketPrint($id)
    {
        $ticket = Ticket::findOrFail($id);
        $printerModel = PrinterConfig::firstOrFail();

        try {
            // Connect to printer
            $connector = new NetworkPrintConnector(
                $printerModel->ip_address,
                $printerModel->port
            );
            $printer = new Printer($connector);

            // Render Blade to plain text
            $content = view('user.ticket', compact('ticket'))->render();
            $text = strip_tags($content);

            // Print
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text($text . "\n\n");
            $printer->cut();
            $printer->close();

            return "Printed successfully!";
        } catch (\Exception $e) {
            return "Print failed: " . $e->getMessage();
        }
    }
}
