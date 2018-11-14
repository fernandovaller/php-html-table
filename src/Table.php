<?php
/**
 * Fernando Valler
 * fernandovaller@gmail.com 
 * Criação de Tabelas em HTML com PHP
 * */
class Table {    

    private $table_attr = [];
    private $heads = [];
    private $heads_attr = [];
    private $heads_attr_key = [];
    private $fields = [];
    private $fields_attr = [];
    private $fields_attr_key = [];

    static public function create() {
        return new static;
    }

    //defini os atributos da tabela
    public function setAttrs($attrs){
        $this->table_attr = $attrs;
        return $this;        
    }    

    //define os titulos
    public function setHeads($heads){
        $this->heads = $heads;
        return $this;
    }    
 
    //defini os atributos dos titulos
    public function setHeadsAttrs($attrs){
        $this->heads_attr = $attrs;
        $this->heads_attr_key = array_keys($attrs);  
        return $this;      
    }     

    //Define os campos
    public function setFields($fields){
        $this->fields = $fields;
        return $this;
    }

    //Define os atribuitos dos campos
    public function setFieldsAttrs($attrs){
        $this->fields_attr = $attrs;
        $this->fields_attr_key = array_keys($attrs);     
        return $this;   
    }  

    //return tr{ ... }
    public function tr($dados){
        return "<tr>". implode('', $dados) ."</tr>";
    }

    //return th{ ... }
    public function th($dados){
        if(in_array($dados, $this->heads_attr_key)){
            $attr = self::parseAttr($this->heads_attr[$dados]);            
        }
        return "<th {$attr}>{$dados}</th>";
    }    

    //return td{ ... }
    public function td($dados, $key = null){        
        if(in_array($key, $this->fields_attr_key)){
            $attr = self::parseAttr($this->fields_attr[$key]);            
        }        
        return "<td {$attr}>{$dados}</td>";
    }    

    //return thead{ ... }
    public function head($dados){
        return "<thead>{$dados}</thead>";
    }

    //return tbody{ ... }
    public function body($dados){
        return "<tbody>{$dados}</tbody>";
    }    

    //return table + attrs { ... }
    public function _table($dados){
        if(isset($this->table_attr) && count($this->table_attr) > 0){
            $attrs = self::parseAttr($this->table_attr);
        }
        return "<table {$attrs}>{$dados}</table>";
    }

    //return tfoot{ ... }
    public function foot($dados){
        return "<tfoot>{$dados}</tfoot>";
    }   

    //return thead{ tr{ td, ... }}
    public function thead($dados){
        $th = array_map(array($this, 'th'), $dados);        
        return self::head(self::tr($th));
    }

    //Entrada: $dados = [ 0 => array(...) ]
    //Saida: tbody{ td{ td, ... } }
    public function tbody($dados){
        foreach ($dados as $row) {
            $td[] = array_map(array($this, 'td'), $row, array_keys($row));
        }
        $tr = array_map(array($this, 'tr'), $td);
        return self::body(self::arrayToString($tr));
    }

    //return tbody{ tr{ td, ... }}
    public function tbodyRow($dados){
        $th = array_map(array($this, 'td'), $dados, array_keys($dados));        
        return self::body(self::tr($th));
    }    

    //return tfoot{ tr{ td, ... }}
    public function tfoot($dados){
        $th = array_map(array($this, 'td'), $dados);        
        return self::foot(self::tr($th));
    }

    //Trasforma um array em uma tabela completa
    //$dados = [ 0 => array('nome' = > 'nome', ....), 1 ....];
    public function dataToTable($dados){

        //titulos
        $heads = array_keys($dados[0]);

        //verifica se vai aplicar filtro de compos aos dados
        if(isset($this->fields) && count($this->fields) > 0){
            $dados = $this->filter($dados);
        }        

        //verifica se vai aplicar filtro de compos aos titulos
        if(isset($this->heads) && count($this->heads) > 0){
            $heads = $this->heads;
        }
            
        $thead = $this->thead($heads);
        $tbody = $this->tbody($dados);        
        return $this->_table($thead . $tbody);        
    }

    
    //transforma o array no formato de atributos
    private static function parseAttr($attributes) {
        if (is_string($attributes)) {
            return (!empty($attributes)) ? ' ' . trim($attributes) : '';
        }
        if (is_array($attributes)) {
            $attr = '';
            foreach ($attributes as $key => $val) {
                $attr .= ' ' . $key . '="' . $val . '"';
            }
            return $attr;
        }
    }

    //filtra os dados apenas com os campos informadados    
    public function filter($dados){
        foreach ($dados as $key => $value) {
            foreach ($value as $key2 => $value2) {
                if(in_array($key2, $this->fields)){
                    $td[$key2] = $value2;
                }                
            }
            $tr[] = $td;
            unset($td);
        }
        return $tr;
    } 

    //return convert array to string
    public static function arrayToString($array){
        return implode("\n", $array);
    }  

}