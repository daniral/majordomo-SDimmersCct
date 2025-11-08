<?php
/*
Создает меню управления.(Запускать 1 раз для каждого объекта).
*/

$sqlQuery="SELECT MAX(id) FROM commands";
$data = SQLSelect($sqlQuery);
$insertID=($data[0]['MAX(id)'])+1;
$objctName=$this->object_title;


//Menu-0
$Record = Array();
$Record['ID']=$insertID;
$Record['TITLE']=$objctName;
$Record['PARENT_ID']=0;
$Record['SUB_LIST']=($insertID+1).",".($insertID+2).",".($insertID+3).",".($insertID+4).",".($insertID+5).",".($insertID+6).",".($insertID+7).",".($insertID+8).",".($insertID+9).",".($insertID+10).",".($insertID+11).",".($insertID+12).",".($insertID+13).",".($insertID+14).",".($insertID+15).",".($insertID+16).",".($insertID+17).",".($insertID+18).",".($insertID+19).",".($insertID+20).",".($insertID+21).",".($insertID+22).",".($insertID+23).",".($insertID+24).",".($insertID+25).",".($insertID+26).",".($insertID+27).",".($insertID+28).",".($insertID+29);
$Record['PARENT_LIST']='0';
$Record['PRIORITY']=10;
$Record['SUB_PRELOAD']=1;
$Record['ICON'] = 'lightLamp.png';
$R=SQLInsert('commands', $Record);


//Menu-1
$Record = Array();
$Record['ID']=($insertID+1);
$Record['TITLE']='Вкл/Выкл';
$Record['PARENT_ID']=($insertID);
$Record['SUB_LIST']=($insertID+1);
$Record['PARENT_LIST']=$insertID;
$Record['PRIORITY']=80;
$Record['TYPE']='switch';
$Record['CUR_VALUE']='1';
$Record['LINKED_OBJECT']=$objctName;
$Record['LINKED_PROPERTY']='status';
$Record['ONCHANGE_METHOD']='switch';
$Record['READ_ONLY']='1';
$R1=SQLInsert('commands', $Record);
//Menu-2
$Record = Array();
$Record['ID']=($insertID+2);
$Record['TITLE']='Яркость';
$Record['PARENT_ID']=($insertID);
$Record['SUB_LIST']=($insertID+2);
$Record['PARENT_LIST']=$insertID;
$Record['PRIORITY']=70;
$Record['TYPE']='sliderbox';
$Record['MIN_VALUE']=0;
$Record['MAX_VALUE']=100;
$Record['CUR_VALUE']='50';
$Record['STEP_VALUE']=1;
$Record['LINKED_OBJECT']=$objctName;
$Record['LINKED_PROPERTY']='level';
$Record['CODE']='callMethod(\''.$objctName.'.setLevel\', array(\'value\' => $new_value));';
$Record['READ_ONLY']='1';
$R2=SQLInsert('commands', $Record);
//Menu-3
$Record = Array();
$Record['ID']=($insertID+3);
$Record['TITLE']='Температура';
$Record['PARENT_ID']=($insertID);
$Record['SUB_LIST']=($insertID+3);;
$Record['PARENT_LIST']=$insertID;
$Record['PRIORITY']=60;
$Record['TYPE']='sliderbox';
$Record['MIN_VALUE']=0;
$Record['MAX_VALUE']=100;
$Record['CUR_VALUE']=0;
$Record['STEP_VALUE']=1;
$Record['LINKED_OBJECT']=$objctName;
$Record['LINKED_PROPERTY']='cctLevel';
$Record['CODE']='callMethod(\''.$objctName.'.setCct\', array(\'value\' => $new_value));';
$Record['READ_ONLY']='1';
$R3=SQLInsert('commands', $Record);


//Menu-4
$Record = Array();
$Record['ID']=($insertID+4);
$Record['TITLE']='Автовключение';
$Record['PARENT_ID']=$insertID;
$Record['SUB_LIST']=($insertID+5).",".($insertID+6).",".($insertID+7).",".($insertID+8);
$Record['PARENT_LIST']=$insertID;
$Record['PRIORITY']=50;
$Record['SUB_PRELOAD']=1;
$R1=SQLInsert('commands', $Record);
    //Menu-5
    $Record = Array();
    $Record['ID']=($insertID+5);
    $Record['TITLE']='Вкл/Выкл';
    $Record['PARENT_ID']=($insertID+4);
    $Record['SUB_LIST']=($insertID+5);
    $Record['PARENT_LIST']=$insertID;
    $Record['PRIORITY']=40;
    $Record['TYPE']='switch';
    $Record['CUR_VALUE']='1';
    $Record['LINKED_OBJECT']=$objctName;
    $Record['LINKED_PROPERTY']='autoOnOff';
    $R2=SQLInsert('commands', $Record);
    //Menu-6
    $Record = Array();
    $Record['ID']=($insertID+6);
    $Record['TITLE']='Задержка(сек)';
    $Record['PARENT_ID']=($insertID+4);
    $Record['SUB_LIST']=($insertID+6);
    $Record['PARENT_LIST']=$insertID;
    $Record['PRIORITY']=30;
    $Record['TYPE']='plusminus';
    $Record['MIN_VALUE']=0;
    $Record['MAX_VALUE']=10000;
    $Record['CUR_VALUE']='40';
    $Record['STEP_VALUE']=5;
    $Record['LINKED_OBJECT']=$objctName;
    $Record['LINKED_PROPERTY']='timerOff';
    $R3=SQLInsert('commands', $Record);
    //Menu-7
    $Record = Array();
    $Record['ID']=($insertID+7);
    $Record['TITLE']='Включать';
    $Record['PARENT_ID']=($insertID+4);
    $Record['SUB_LIST']=($insertID+7);
    $Record['PARENT_LIST']=$insertID;
    $Record['PRIORITY']=20;
    $Record['TYPE']='selectbox';
    $Record['CUR_VALUE']='2';
    $Record['LINKED_OBJECT']=$objctName;
    $Record['LINKED_PROPERTY']='workingDay';
    $Record['DATA']="1=Днем\r\n2=Ночью\r\n0=Круглосутлчно";
    $R4=SQLInsert('commands', $Record);
    //Menu-8
    $Record = Array();
    $Record['ID']=($insertID+8);
    $Record['TITLE']='Работать по';
    $Record['PARENT_ID']=($insertID+4);
    $Record['SUB_LIST']=($insertID+8);
    $Record['PARENT_LIST']=$insertID;
    $Record['PRIORITY']=10;
    $Record['TYPE']='selectbox';
    $Record['CUR_VALUE']='2';
    $Record['LINKED_OBJECT']=$objctName;
    $Record['LINKED_PROPERTY']='workingBy';
    $Record['DATA']="1=Времени\r\n2=Солнцу\r\n3=Датчику";
    $R4=SQLInsert('commands', $Record);


//Menu-9
$Record = Array();
$Record['ID']=($insertID+9);
$Record['TITLE']='Солнце';
$Record['PARENT_ID']=$insertID;
$Record['SUB_LIST']=($insertID+10).",".($insertID+11).",".($insertID+12).",".($insertID+13);
$Record['PARENT_LIST']=$insertID;
$Record['PRIORITY']=40;
$Record['SUB_PRELOAD']=1;
$R5=SQLInsert('commands', $Record);
    //Menu-10
    $Record = Array();
    $Record['ID']=($insertID+10);
    $Record['TITLE']='Восход';
    $Record['PARENT_ID']=($insertID+9);
    $Record['SUB_LIST']=($insertID+10);
    $Record['PARENT_LIST']=$insertID;
    $Record['PRIORITY']=40;
    $Record['TYPE']='timebox';
    $Record['MIN_VALUE']=-21600;
    $Record['MAX_VALUE']=21600;
    $Record['CUR_VALUE']='00:00';
    $Record['STEP_VALUE']=60;
    $Record['LINKED_OBJECT']=$objctName;
    $Record['LINKED_PROPERTY']='addTimeSunrise';
    $R7=SQLInsert('commands', $Record);
    //Menu-11
    $Record = Array();
    $Record['ID']=($insertID+11);
    $Record['TITLE']='Прибавить/Отнять';
    $Record['PARENT_ID']=($insertID+9);
    $Record['SUB_LIST']=($insertID+11);
    $Record['PARENT_LIST']=$insertID;
    $Record['PRIORITY']=30;
    $Record['TYPE']='selectbox';
    $Record['CUR_VALUE']='1';
    $Record['LINKED_OBJECT']=$objctName;
    $Record['LINKED_PROPERTY']='signSunrise';
    $Record['DATA']="1=Прибавить\r\n0=Отнять";
    $R8=SQLInsert('commands', $Record);
    //Menu-12
    $Record = Array();
    $Record['ID']=($insertID+12);
    $Record['TITLE']='Закат';
    $Record['PARENT_ID']=($insertID+9);
    $Record['SUB_LIST']=($insertID+12);
    $Record['PARENT_LIST']=$insertID;
    $Record['PRIORITY']=20;
    $Record['TYPE']='timebox';
    $Record['MIN_VALUE']=-21600;
    $Record['MAX_VALUE']=21600;
    $Record['CUR_VALUE']='00:30';
    $Record['STEP_VALUE']=60;
    $Record['LINKED_OBJECT']=$objctName;
    $Record['LINKED_PROPERTY']='addTimeSunset';
    $R9=SQLInsert('commands', $Record);
    //Menu-13
    $Record = Array();
    $Record['ID']=($insertID+13);
    $Record['TITLE']='Прибавить/Отнять';
    $Record['PARENT_ID']=($insertID+9);
    $Record['SUB_LIST']=($insertID+13);
    $Record['PARENT_LIST']=$insertID;
    $Record['PRIORITY']=10;
    $Record['TYPE']='selectbox';
    $Record['LINKED_OBJECT']=$objctName;
    $Record['LINKED_PROPERTY']='signSunset';
    $Record['DATA']="1=Прибавить\r\n0=Отнять";
    $R10=SQLInsert('commands', $Record);


//Menu-14
$Record = Array();
$Record['ID']=($insertID+14);
$Record['TITLE']='Датчик';
$Record['PARENT_ID']=$insertID;
$Record['SUB_LIST']=($insertID+15);
$Record['PARENT_LIST']=$insertID;
$Record['PRIORITY']=30;
$Record['SUB_PRELOAD']=1;
$R11=SQLInsert('commands', $Record);
    //Menu-15
    $Record = Array();
    $Record['ID']=($insertID+15);
    $Record['TITLE']='Макс.Освещение';
    $Record['PARENT_ID']=$insertID+14;
    $Record['SUB_LIST']=$insertID+15;
    $Record['PARENT_LIST']=$insertID;
    $Record['PRIORITY']=10;
    $Record['TYPE']='plusminus';
    $Record['MIN_VALUE']=0;
    $Record['MAX_VALUE']=500;
    $Record['CUR_VALUE']='15';
    $Record['STEP_VALUE']=1;
    $Record['LINKED_OBJECT']=$objctName;
    $Record['LINKED_PROPERTY']='illuminanceMax';
    $R13=SQLInsert('commands', $Record);


//Menu-16
$Record = Array();
$Record['ID']=($insertID+16);
$Record['TITLE']='Время';
$Record['PARENT_ID']=$insertID;
$Record['SUB_LIST']=($insertID+17).",".($insertID+18);
$Record['PARENT_LIST']=$insertID;
$Record['PRIORITY']=20;
$Record['SUB_PRELOAD']=1;
$R14=SQLInsert('commands', $Record);
    //Menu-17
    $Record = Array();
    $Record['ID']=($insertID+17);
    $Record['TITLE']='Начало Ночь';
    $Record['PARENT_ID']=($insertID+16);
    $Record['SUB_LIST']=($insertID+17);
    $Record['PARENT_LIST']=$insertID;
    $Record['PRIORITY']=20;
    $Record['TYPE']='timebox';
    $Record['MIN_VALUE']=-21600;
    $Record['MAX_VALUE']=21600;
    $Record['CUR_VALUE']='18:00';
    $Record['STEP_VALUE']=60;
    $Record['LINKED_OBJECT']=$objctName;
    $Record['LINKED_PROPERTY']='nightBegin';
    $R16=SQLInsert('commands', $Record);
    //Menu-18
    $Record = Array();
    $Record['ID']=($insertID+18);
    $Record['TITLE']='Начало День';
    $Record['PARENT_ID']=($insertID+16);
    $Record['SUB_LIST']=($insertID+18);
    $Record['PARENT_LIST']=$insertID;
    $Record['PRIORITY']=10;
    $Record['TYPE']='timebox';
    $Record['MIN_VALUE']=-21600;
    $Record['MAX_VALUE']=21600;
    $Record['CUR_VALUE']='08:00';
    $Record['STEP_VALUE']=60;
    $Record['LINKED_OBJECT']=$objctName;
    $Record['LINKED_PROPERTY']='dayBegin';
    $R17=SQLInsert('commands', $Record);


//Menu-19
$Record = Array();
$Record['ID']=($insertID+19);
$Record['TITLE']='Цвет';
$Record['PARENT_ID']=$insertID;
$Record['SUB_LIST']=($insertID+20).",".($insertID+25);
$Record['PARENT_LIST']=$insertID;
$Record['PRIORITY']=10;
$Record['SUB_PRELOAD']=1;
$R17=SQLInsert('commands', $Record);
    //Menu-20
    $Record = Array();
    $Record['ID']=($insertID+20);
    $Record['TITLE']='Яркость';
    $Record['PARENT_ID']=$insertID+19;
    $Record['SUB_LIST']=($insertID+21).",".($insertID+22).",".($insertID+23).",".($insertID+24);
    $Record['PARENT_LIST']=$insertID;
    $Record['PRIORITY']=20;
    $Record['SUB_PRELOAD']=1;
    $R17=SQLInsert('commands', $Record);
        //Menu-21
        $Record = Array();
        $Record['ID']=($insertID+21);
        $Record['TITLE']='Днем';
        $Record['PARENT_ID']=($insertID+20);
        $Record['SUB_LIST']=($insertID+21);
        $Record['PARENT_LIST']=$insertID;
        $Record['PRIORITY']=40;
        $Record['TYPE']='sliderbox';
        $Record['MIN_VALUE']=0;
        $Record['MAX_VALUE']=100;
        $Record['CUR_VALUE']='100';
        $Record['STEP_VALUE']=1;
        $Record['LINKED_OBJECT']=$objctName;
        $Record['LINKED_PROPERTY']='dayLevel';
        $R18=SQLInsert('commands', $Record);
        //Menu-22
        $Record = Array();
        $Record['ID']=($insertID+22);
        $Record['TITLE']='Ночью';
        $Record['PARENT_ID']=($insertID+20);
        $Record['SUB_LIST']=($insertID+22);
        $Record['PARENT_LIST']=$insertID;
        $Record['PRIORITY']=30;
        $Record['TYPE']='sliderbox';
        $Record['MIN_VALUE']=0;
        $Record['MAX_VALUE']=100;
        $Record['CUR_VALUE']='10';
        $Record['STEP_VALUE']=1;
        $Record['LINKED_OBJECT']=$objctName;
        $Record['LINKED_PROPERTY']='nightLevel';
        $R20=SQLInsert('commands', $Record);
        //Menu-23
        $Record = Array();
        $Record['ID']=($insertID+23);
        $Record['TITLE']='Максимальная';
        $Record['PARENT_ID']=($insertID+20);
        $Record['SUB_LIST']=($insertID+23);
        $Record['PARENT_LIST']=$insertID;
        $Record['PRIORITY']=20;
        $Record['TYPE']='sliderbox';
        $Record['MIN_VALUE']=0;
        $Record['MAX_VALUE']=1000;
        $Record['CUR_VALUE']='254';
        $Record['STEP_VALUE']=1;
        $Record['LINKED_OBJECT']=$objctName;
        $Record['LINKED_PROPERTY']='maxWork';
        $R20=SQLInsert('commands', $Record);
        //Menu-24
        $Record = Array();
        $Record['ID']=($insertID+24);
        $Record['TITLE']='Минимальная';
        $Record['PARENT_ID']=($insertID+20);
        $Record['SUB_LIST']=($insertID+24);
        $Record['PARENT_LIST']=$insertID;
        $Record['PRIORITY']=10;
        $Record['TYPE']='sliderbox';
        $Record['MIN_VALUE']=0;
        $Record['MAX_VALUE']=1000;
        $Record['CUR_VALUE']='0';
        $Record['STEP_VALUE']=1;
        $Record['LINKED_OBJECT']=$objctName;
        $Record['LINKED_PROPERTY']='minWork';
        $R20=SQLInsert('commands', $Record);
    //Menu-25
    $Record = Array();
    $Record['ID']=($insertID+25);
    $Record['TITLE']='Температура';
    $Record['PARENT_ID']=$insertID+19;
    $Record['SUB_LIST']=($insertID+26).",".($insertID+27).",".($insertID+28).",".($insertID+29);
    $Record['PARENT_LIST']=$insertID;
    $Record['PRIORITY']=10;
    $Record['SUB_PRELOAD']=1;
    $R17=SQLInsert('commands', $Record);
        //Menu-26
        $Record = Array();
        $Record['ID']=($insertID+26);
        $Record['TITLE']='Днем';
        $Record['PARENT_ID']=($insertID+25);
        $Record['SUB_LIST']=($insertID+26);
        $Record['PARENT_LIST']=$insertID;
        $Record['PRIORITY']=40;
        $Record['TYPE']='sliderbox';
        $Record['MIN_VALUE']=0;
        $Record['MAX_VALUE']=100;
        $Record['CUR_VALUE']='0';
        $Record['STEP_VALUE']=1;
        $Record['LINKED_OBJECT']=$objctName;
        $Record['LINKED_PROPERTY']='dayCct';
        $R19=SQLInsert('commands', $Record);
        //Menu-27
        $Record = Array();
        $Record['ID']=($insertID+27);
        $Record['TITLE']='Ночью';
        $Record['PARENT_ID']=($insertID+25);
        $Record['SUB_LIST']=($insertID+27);
        $Record['PARENT_LIST']=$insertID;
        $Record['PRIORITY']=30;
        $Record['TYPE']='sliderbox';
        $Record['MIN_VALUE']=0;
        $Record['MAX_VALUE']=100;
        $Record['CUR_VALUE']='100';
        $Record['STEP_VALUE']=1;
        $Record['LINKED_OBJECT']=$objctName;
        $Record['LINKED_PROPERTY']='nightCct';
        $R21=SQLInsert('commands', $Record);
        //Menu-28
        $Record = Array();
        $Record['ID']=($insertID+28);
        $Record['TITLE']='Максимальная';
        $Record['PARENT_ID']=($insertID+25);
        $Record['SUB_LIST']=($insertID+28);
        $Record['PARENT_LIST']=$insertID;
        $Record['PRIORITY']=20;
        $Record['TYPE']='sliderbox';
        $Record['MIN_VALUE']=1;
        $Record['MAX_VALUE']=1000;
        $Record['CUR_VALUE']='370';
        $Record['STEP_VALUE']=1;
        $Record['LINKED_OBJECT']=$objctName;
        $Record['LINKED_PROPERTY']='cctMaxWork';
        $R19=SQLInsert('commands', $Record);
        //Menu-29
        $Record = Array();
        $Record['ID']=($insertID+29);
        $Record['TITLE']='Минимальная';
        $Record['PARENT_ID']=($insertID+25);
        $Record['SUB_LIST']=($insertID+29);
        $Record['PARENT_LIST']=$insertID;
        $Record['PRIORITY']=10;
        $Record['TYPE']='sliderbox';
        $Record['MIN_VALUE']=1;
        $Record['MAX_VALUE']=1000;
        $Record['CUR_VALUE']='153';
        $Record['STEP_VALUE']=1;
        $Record['LINKED_OBJECT']=$objctName;
        $Record['LINKED_PROPERTY']='cctMinWork';
        $R21=SQLInsert('commands', $Record);
