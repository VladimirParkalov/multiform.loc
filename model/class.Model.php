<?php
class Model
{
    public function _tpl_($_tpl_,$v=array())
    {
        extract($v,EXTR_SKIP);
        ob_start();
        include($_SERVER['DOCUMENT_ROOT'].'/templates/'.$_tpl_);
        return ob_get_clean();
    }
    public function signZodiac($data)
    {
        $arrData = explode('-',$data);
        $day = $arrData[2];
        $month = $arrData[1];
        $zodiac = array('capricorn','aquarius','pisces','aries','taurus','gemini','cancer','leo','virgo','libra','scorpio','sagittarius');
        $signsstart = array(1=>21, 2=>20, 3=>20, 4=>20, 5=>20, 6=>20, 7=>21, 8=>22, 9=>23, 10=>23, 11=>23, 12=>23);
        return $day < $signsstart[$month + 1] ? $zodiac[$month - 1] : $zodiac[$month % 12];
    }

    public function save($step, $data)
    {
        $fields = explode('&',$data);
        foreach ($fields as $field) {
            $keyVal = explode('=', $field);
            $key = urldecode($keyVal[0]);
            $val = urldecode($keyVal[1]);
            $_SESSION[$step][$key] = $val;
        }
    }
}
?>