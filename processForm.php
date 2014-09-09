<?php
include_once('config/config.php');
include_once('mysql/class.MySQL.php');
include_once('model/class.Model.php');
$oMySQL = new MySQL(MYSQL_DATABASE_NAME, MYSQL_USER, MYSQL_PASS,MYSQL_HOST,MYSQL_PORT);
$oModel = new Model();
session_start();

$step = $_REQUEST['newStep'];
$currStep = $_REQUEST['currStep'];
$formData = $_REQUEST['formData'];

if ($formData)
{
    $oModel->save($currStep, $formData);
}

if ($step) {
	switch ($step) {
		case 'formstep1':
            $checkedm = $_SESSION[$step]['fm-sex']=='male'?'checked':'';
            $checkedf = $_SESSION[$step]['fm-sex']=='female'?'checked':'';
            echo $oModel->_tpl_('formstep1.php',array(
                        'step'=>$step,
                        'firstname'=>$_SESSION[$step]['fm-firstname'],
                        'checkedm'=>$checkedm,
                        'checkedf'=>$checkedf
                    )
                );
		break;
		case 'formstep2':
            $options = explode(",","dolnośląskie, kujawsko-pomorskie, lubelskie, lubuskie, łódzkie, małopolskie,mazowieckie, opolskie, podkarpackie, podlaskie, pomorskie, śląskie, świętokrzyskie, warmińsko-mazurskie, wielkopolskie, zachodniopomorskie");
            echo $oModel->_tpl_('formstep2.php',array(
                    'step'=>$step,
                    'date'=>$_SESSION[$step]['fm-date'],
                    'selected'=>$_SESSION[$step]['fm-voievodeship'],
                    'options'=>$options,
                )
            );
            break;
		case 'formstep3':
            echo $oModel->_tpl_('formstep3.php',array(
                    'step'=>$step,
                    'email'=>$_SESSION[$step]['fm-email'],
                    'checkbox'=>$_SESSION[$step]['fm-checkbox']?'checked':'',
                )
            );
		break;
		case 'getAllData':
            $dataSessionForm = $_SESSION;
            foreach($dataSessionForm as $k=>$value)
            {
                switch ($k)
                {
                    case 'formstep1':
                        $dataInsert['Sex'] = $value['fm-sex'];
                        $dataTypes['Sex'] = 'str';
                        $dataInsert['Name'] = $value['fm-firstname'];
                        $dataTypes['Name'] = 'str';
                        break;
                    case 'formstep2':
                        $dataInsert['BDate'] = $value['fm-date'];
                        $dataTypes['BDate'] = 'str';
                        $dataInsert['Voievodeship'] = $value['fm-voievodeship'];
                        $dataTypes['Voievodeship'] = 'str';
                        $dataInsert['zodiac'] = $oModel->signZodiac($value['fm-date']);
                        $dataTypes['zodiac'] = 'str';
                        break;
                    case 'formstep3':
                        $dataInsert['email'] = $value['fm-email'];
                        $dataTypes['email'] = 'email';
                        $dataInsert['checkbox'] = $value['fm-checkbox']=='on'?1:0;
                        $dataTypes['checkbox'] = 'bool';
                    break;
                    default:

                }

            }
//            echo '<div style="text-align: left;"><pre>';
//            print_r($dataInsert);
//            print_r($oMySQL);
//            echo '</pre></div>';
            if($oMySQL->insert('horoskop',$dataInsert,'',$dataTypes))
            {
                $oMySQL->closeConnection();
                session_destroy();
                echo '<h3>Data Saved </h3>';
                echo '<h3>redirect to '.$dataInsert['zodiac'].' </h3>';
            }
            else
            {
                $oMySQL->closeConnection();
                echo '<h3>Data not saved </h3>';
            }
		break;
	}
}

