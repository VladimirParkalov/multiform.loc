<?php
include_once('templates_helper.php');
include_once('config/config.php');
include_once('mysql/class.MySQL.php');
$oMySQL = new MySQL(MYSQL_DATABASE_NAME, MYSQL_USER, MYSQL_PASS,MYSQL_HOST,MYSQL_PORT);
session_start();

$step = $_REQUEST['step'];
$formData = $_REQUEST['formData'];
//var_dump($formData);exit;

function save($step, $data)
{
	$fields = explode('&',$data);
	foreach ($fields as $field) {
		$keyVal = explode('=', $field);
		$key = urldecode($keyVal[0]);
		$val = urldecode($keyVal[1]);
		$_SESSION[$step][$key] = $val;
	}
}

if ($formData)
{
	$formStep = $_REQUEST['saveData'];
	save($formStep, $_REQUEST['formData']);
}

if ($step) {
	switch ($step) {
		case 'formstep1':
            $checkedm = $_SESSION[$step]['fm-sex']=='male'?'checked':'';
            $checkedf = $_SESSION[$step]['fm-sex']=='female'?'checked':'';
            echo _tpl_('formstep1.php',array(
                        'step'=>$step,
                        'firstname'=>$_SESSION[$step]['fm-firstname'],
                        'checkedm'=>$checkedm,
                        'checkedf'=>$checkedf
                    )
                );
		break;
		case 'formstep2':
            $options = array(
                'aries'=>'Aries: March 21 – April 20',
                'taurus'=>'Taurus: April 21 – May 20',
                'gemini'=>'Gemini: May 21 – June 20',
                'cancer'=>'Cancer: June 21 – July 20',
                'leo'=>'Leo: July 21 – August 20',
                'virgo'=>'Virgo: August 21 – September 20',
                'libra'=>'Libra: September 21 – October 20',
                'scorpio'=>'Scorpio: October 21 – November 20',
                'sagittarius'=>'Sagittarius: November 21 – December 20',
                'capricorn'=>'Capricorn: December 21 – January 20',
                'aquarius'=>'Aquarius: January 21 – February 20',
                'pisces'=>'Pisces: February 21 – March 20'
            );
            echo _tpl_('formstep2.php',array(
                    'step'=>$step,
                    'voievodeship'=>$_SESSION[$step]['fm-voievodeship'],
                    'selected'=>$_SESSION[$step]['fm-date'],
                    'options'=>$options,
                )
            );
            break;
		case 'formstep3':
            echo _tpl_('formstep3.php',array(
                    'step'=>$step,
                    'email'=>$_SESSION[$step]['fm-email'],
                    'checkbox'=>$_SESSION[$step]['fm-checkbox']?'checked':'',
                )
            );
		break;
		case 'getAllData':
            $dataSessionForm = $_SESSION;
//            Sex,Name,BDate,Voievodeship,email,checkbox
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
            echo '<div style="text-align: left;"><pre>';
//            print_r($dataInsert);
//            print_r($oMySQL);
            echo '</pre></div>';
            if($oMySQL->insert('horoskop',$dataInsert,'',$dataTypes))
            {
                $oMySQL->closeConnection();
                session_destroy();
                echo '<h3>Data Saved </h3>';
                echo '<h3>redirect to '.$dataInsert['BDate'].' </h3>';
            }
            else
            {
                echo '<h3>Data not saved </h3>';
            }


//			echo '<div style="text-align: left;"><pre>';
//			print_r($dataSessionForm);
//			echo '</pre></div>';
		break;
	}
}

