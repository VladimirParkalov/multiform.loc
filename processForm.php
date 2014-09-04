<?php
include_once('templates_helper.php');
include_once('config/config.dev.php');
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
            echo _tpl_('formstep2.php',array(
                    'step'=>$step,
                    'voievodeship'=>$_SESSION[$step]['fm-voievodeship'],
                    'optionselect'=>$_SESSION[$step]['fm-date'],
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
                    case '':
                        $dataInsert['Sex'] = $value['fm-sex'];
                        $dataTypes['sex'] = 'bool';
                        break;
                    case '':
                        $dataInsert['Name'] = $value['fm-firstname'];
                        $dataTypes['Name'] = 'str';
                    break;
                    case '':
                        $dataInsert['Sex'] = $value['fm-sex'];
                        $dataTypes[] = 'int';
                    break;
                    default:

                }

            }
            $oMySQL->insert('horoskop',$dataInsert,'',$dataTypes);
			echo '<h3>Saved Data</h3>';
			echo '<div style="text-align: left;"><pre>';
			print_r($dataSessionForm);
			echo '</pre></div>';
		break;
	}
}

