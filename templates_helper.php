<?php
    function _tpl_($_tpl_,$v=array())
    {
        extract($v,EXTR_SKIP);
        ob_start();
        include($_SERVER['DOCUMENT_ROOT'].'/templates/'.$_tpl_);
        return ob_get_clean();
    }
?>