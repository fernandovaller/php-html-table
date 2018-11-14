<?php  

require_once 'src/Table.php';

$dados = [
    0 => ['id'=> 6513, 'nome' => 'Dallin Heathcote', 'email' => 'daren47@example.org'],
    1 => ['id'=> 7698, 'nome' => 'Ali Greenfelder', 'email' => 'durward.mayert@example.org'],
    2 => ['id'=> 4365, 'nome' => 'Odell Howe', 'email' => 'tressa.waelchi@example.com'],
    3 => ['id'=> 8220, 'nome' => 'Elisha Labadie', 'email' => 'brown.sophie@example.org'],
    4 => ['id'=> 2814, 'nome' => 'Domingo Cummings', 'email' => 'yleffler@example.org'],
    5 => ['id'=> 7048, 'nome' => 'Dr. Savannah Pagac II', 'email' => 'csanford@example.com'],
    6 => ['id'=> 7798, 'nome' => 'Terrell Kreiger DVM', 'email' => 'jason.will@example.net'],
    7 => ['id'=> 6619, 'nome' => 'Sheridan Jerde', 'email' => 'goyette.dorcas@example.org']
];

$attr = ['border'=> 1, 'class'=>'table table-hover', 'width'=>'100%'];

$table = Table::create()
                ->setAttrs($attr)
                ->dataToTable($dados);
echo $table;             
?>