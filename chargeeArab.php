<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generation of Moodle Question Bank containing same level questions and answers</title>
    <style>
        form {
            border:none;

        }

        head {
            width: 50px;
            height: 20px;
        }

        h1 {
            color: rgba(0, 0, 0, 15);
        }

        .label {
            text-align: left;
        }

        .Q1 input {
            width: 300pt;
            height: 20pt;
        }

        .R1 input {
            width: 300pt;
            height: 20pt;

        }

        .table {

            margin: 30px 9px;
            border: 1px solid rgba(0, 0, 0, 15)
        }

        thead {
            background-color: #f3f3f3;

            text-align: left;
        }

        th,
        td {
            padding: 15px 30px;
        }

        tbody,
        th,
        td,
        tr {
            border: 1px solid #ddd;
        }

        .td {
            border: 0cm;
        }

        .zontd {
            border: 0cm;
        }

        .bttn input {
            width: 80pt;
            height: 20pt;
            margin: 0px 20px;
            background-color: #0f6fc5;
            color: #fff;
        }

        #Generate {
            width: 60pt;
            height: 17pt;
            margin: 0px 35px;
            background-color: #0f6fc5;
            color: #fff;
        }
        p{
            color: red;
        }
        .cadr{
              width: 450pt;   
             border: 1px solid black;
             padding: 10px;              
            
        }
        .lang-menu {
  display: flex;
  list-style: none;
  padding: 0;
  margin: 0;
}

.lang-menu a {
  display: block;
  padding: 10px 20px;
}

.lang{
  width: 75pc;
  height: 40px;
  background-color: #fff;
  box-shadow: 0 0px 3px rgba(0, 0, 0, 10);

}
    </style>

</head>
<!--------------------------------------------------------------php--------------------------------------------------------------->

<body dir="rtl">
<nav class="lang">
	    <ul class="lang-menu">
		<li><a href="chargee.php">English</a></li>
		<li><a href="chargeeArab.php">العربية</a></li>
	    </ul>
        </nav>
    <center>

        <?php
    session_start(); 
    
        ?>
        <?php 
        ////////////////////////////////////////////////SAVEASMOODLEXML///////////////////////////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////SAVEASMOODLEXML///////////////////////////////////////////////////////////////////////////////////
        // Vérification de la soumission du formulaire
        if (isset($_POST['saveasmoodle'])) {
            // Récupération des données saisies par l'utilisateur
            $bank = $_POST['bank'];
            $cols = $_POST['cols'];
            $rows = $_POST['rows'];
            $Question = $_POST['Question'];
            $Reponse1 = $_POST['Reponse1'];
            $nmbrans = $_POST['answer'];
            $mark  =  $_POST['mark'];
            // Création du document XML
            $quizz = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><quiz></quiz>');
        
            // Ajout s à l'objet XML
            $Q1 = $quizz->addChild('question');
            $Q1->addAttribute('type', 'category');
            $catgry= $Q1->addChild('category', '');
            $textcat= $catgry->addChild('text', $bank);        
        
             //tableau de mot 
             $tab=array();
              for($i=1;$i<=$cols ;$i++){
                  $tab[$i]=$_POST[ '1f' . $i ]; 
               }
               // NOMBRE DE QEUSTION
              for($c=1;$c<=$rows;$c++){

                $tablig=array();
                for($i=1;$i<=$cols ;$i++){
                    $tablig[$i]=$_POST[ $c.'f' . $i ];
                }
                $Questiontab  = explode(" ", $Question);



               
                $answerxml = array();
                for ($a=1; $a<=$nmbrans; $a++) {
                    $newrep = '';
                   
                    $rep = $_POST['Reponse'.$a];
                    $prctg = $_POST['prctg'.$a];
                    $answertab = explode(" ", $rep);
                    $prctgg= '%'.$prctg;
                    $newrep .= $prctgg . '';
                    foreach ($answertab as $word) {
                        for ($l = 1; $l <= $cols; $l++) {
                            if ($word == $tab[$l]) {
                                $word = $tablig[$l];
                            }
                        }
                        $newrep .= $word . ' ';
                    }
                    if($a<$nmbrans){
                        $fdy='~';
                        $newrep .= $fdy . '';
                    }
                   
                    $newrep = rtrim($newrep, '');
                    $answerxml[] = $newrep;
                }

                $answerxmll =implode('', $answerxml);

                $newQuestion = '';
                foreach ($Questiontab as $word) {
                    for ($l = 1; $l <= $cols; $l++) {
                        if ($word == $tab[$l]) {
                            $word = $tablig[$l];
                        }
                    }
                    $newQuestion .= $word . ' ';
                }
        
                $newQuestion = rtrim($newQuestion, ' ');
        
                $Q2 = $quizz->addChild('question');
                $Q2->addAttribute('type', 'cloze');
                $name=$Q2->addchild('name','');
                $name->addchild('text','Question-'.$c.'');
                $qtx= $Q2->addChild('questiontext', "");
              $qtx->addchild('text',"  ".$newQuestion."{".$mark.":SHORTANSWER:".$answerxmll."}  ");
              $Q2->addAttribute('texttype', 'text/html');
            }
                 
            // Enregistrement du fichier XML
            $quizz->asXML('moodle_'.$bank.'.xml');
        
            // Message de confirmation
            echo ' <a href="' . $bank . '.xml" download>تم حفظ البيانات. حمّل الملف"  </a> ';
        
        }
        
                


        /////////////////////////////////////////////////////SAVEas/////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////SAVEAS///////////////////////////////////////////////////////////////////////////////////
        // Vérification de la soumission du formulaire

       
    
        if (isset($_POST['saveas'])) {
           
            // Récupération des données saisies par l'utilisateur
            $saveass = $_POST['saveass'];
            $bank = $_POST['bank'];
            $cols = $_POST['cols'];
            $rows = $_POST['rows'];
            $Question = $_POST['Question'];
            $Reponse1 = $_POST['Reponse1'];
            $prctg  =  $_POST['prctg1'];
            $nmbrans = $_POST['answer'];
            $mark  =  $_POST['mark'];
          


            $i = 0;
            $j = 0;
            // Création du document XML

            $quizz = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><QuestionsBank></QuestionsBank>');
           
             //tableau de mot 
             $tab=array();
             for($i=1;$i<=$cols ;$i++){
             $tab[$i]=$_POST[ '1f' . $i ]; ; 
           
         }
          //deveser la qustion en mots 
        $Questiontab  = explode(" ", $Question);
        //recomposer le text
           for ($j = 0; $j < count($Questiontab); $j++) {
                $fld=$Questiontab[$j];
              for ($k = 1; $k <= count($tab); $k++) {
                   if ($fld == $tab[$k]) {
                    $Question = preg_replace('/\b'.$fld.'\b/', '#%'.$k .'_'.$fld.'%#', $Question);
                   }
                   else {
                    $Question = preg_replace('/\b'.preg_quote($fld, '/').'\b/', $fld, $Question);

                     }
                }
            }
             //deveser la reponce  en mots 

             $reptab  = explode(" ",$Reponse1);
             //tableau de mot 
            for ($j = 0; $j < count($reptab); $j++) {
                 $fld=$reptab[$j];
               for ($k = 1; $k <= count($tab); $k++) {
                    if ($fld == $tab[$k]) {
                        $Reponse1 = preg_replace('/\b'.$fld.'\b/', '#%'.$k .'_'.$fld.'%#', $Reponse1);
                    }
                    else {
                        $Reponse1 = preg_replace('/\b'.preg_quote($fld, '/').'\b/', $fld, $Reponse1);

                      }
                 }
             }

            // Ajout à l'objet XML

            $name = $quizz->addChild("name", $bank);
            $nmbrof = $quizz->addChild("numberOfFiled", $cols);
            $nmbrofQ = $quizz->addChild("numberOfSimilerQuestion", $rows);
            
            $qt = $quizz->addChild('QuestionText', $Question);

            $mark = $quizz->addChild("totalGrad ", $mark);
            $nmbranswer = $quizz->addChild("numberOfAnswer ", $nmbrans);
            
            //answer+attribut
            $answer = $quizz->addChild('Answer ', $Reponse1);
            $answer->addAttribute('value', $prctg);

            for ($j = 2; $j <=$nmbrans; $j++) {
                $answerr = $_POST['Reponse' . $j];
                $prcntgg = $_POST['prctg' . $j];
                $repptab  = explode(" ",$answerr);
                for ($l = 0; $l < count($repptab); $l++) {
                    $fld=$repptab[$l];
                  
                  for ($k = 1; $k <= count($tab); $k++) {
                       if ($fld == $tab[$k]) {
                        $answerr = preg_replace('/\b'.$fld.'\b/', '#%'.$k .'_'.$fld.'%#',  $answerr);
                       
                       }
                       else {
                        $answerr = preg_replace('/\b'.preg_quote($fld, '/').'\b/', $fld, $answerr);

                         }
                    }
                }


                $answerj = $quizz->addChild('Answer ', $answerr);
                $answerj->addAttribute('value', $prcntgg);

            }
            for ($i=1;$i<=$rows;$i++){
                $table_row = $quizz->addChild('Similar');
                $table_row->addAttribute('id', $i);
            for ($j=1;$j<=$cols;$j++){
                $value = $_POST[ $i . 'f' . $j ];
                $field = $table_row->addChild('Field ', $value);
                $field->addAttribute('name', 'Field' . $j . ''); }


          }

            // Enregistrement du fichier XML
            $quizz->asXML("" . $saveass . ".xml");
              // Message de confirmation
              echo ' <a href="' . $saveass . '.xml" download>تم حفظ البيانات. حمّل الملف  </a> ';
              // Téléchargement automatique du fichier XML


          
        }
        ////////////////////////////////////////////////SAVE///////////////////////////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////SAVE///////////////////////////////////////////////////////////////////////////////////
        // Vérification de la soumission du formulaire

        if (isset($_POST['save'])) {

            // Récupération des données saisies par l'utilisateur
            $bank = $_POST['bank'];
            $cols = $_POST['cols'];
            $rows = $_POST['rows'];
            $Question = $_POST['Question'];
            $Reponse1 = $_POST['Reponse1'];
            $prctg  =  $_POST['prctg1'];
            $nmbrans = $_POST['answer'];
            $mark  =  $_POST['mark'];
            $i = 0;
            $j = 0;
            // Création du document XML

            $quizz = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><QuestionsBank></QuestionsBank>');
           
           
            //tableau de mot 
            $tab=array();
            for($i=1;$i<=$cols ;$i++){
            $tab[$i]=$_POST[ '1f' . $i ]; ; 
          
        }

        //deveser la qustion en mots 
        $Questiontab  = explode(" ", $Question);
        //recomposer le text
           for ($j = 0; $j < count($Questiontab); $j++) {
                $fld=$Questiontab[$j];
              for ($k = 1; $k <= count($tab); $k++) {
                   if ($fld == $tab[$k]) {
                    $Question = preg_replace('/\b'.$fld.'\b/', '#%'.$k .'_'.$fld.'%#', $Question);
                   }
                   else {
                    $Question = preg_replace('/\b'.preg_quote($fld, '/').'\b/', $fld, $Question);

                     }
                }
            }
             //deveser la reponce  en mots 

             $reptab  = explode(" ",$Reponse1);
             //tableau de mot 
            for ($j = 0; $j < count($reptab); $j++) {
                 $fld=$reptab[$j];
               for ($k = 1; $k <= count($tab); $k++) {
                    if ($fld == $tab[$k]) {
                        $Reponse1 = preg_replace('/\b'.$fld.'\b/', '#%'.$k .'_'.$fld.'%#', $Reponse1);
                    }
                    else {
                        $Reponse1 = preg_replace('/\b'.preg_quote($fld, '/').'\b/', $fld, $Reponse1);

                      }
                 }
             }


            // Ajout à l'objet XML
            $name = $quizz->addChild("name", $bank);
            $nmbrof = $quizz->addChild("numberOfFiled", $cols);
            $nmbrofQ = $quizz->addChild("numberOfSimilerQuestion", $rows);
            
            $qt = $quizz->addChild('QuestionText', $Question);

            $mark = $quizz->addChild("totalGrad ", $mark);
            $nmbranswer = $quizz->addChild("numberOfAnswer ", $nmbrans);
            
            //answer+attribut
            $answer = $quizz->addChild('Answer ', $Reponse1);
            $answer->addAttribute('value', $prctg);
           
            for ($j = 2; $j <=$nmbrans; $j++) {
                $answerr = $_POST['Reponse' . $j];
                $prcntgg = $_POST['prctg' . $j];
                $repptab  = explode(" ",$answerr);
                for ($l = 0; $l < count($repptab); $l++) {
                    $fld=$repptab[$l];
                  
                  for ($k = 1; $k <= count($tab); $k++) {
                       if ($fld == $tab[$k]) {
                        $answerr = preg_replace('/\b'.$fld.'\b/', '#%'.$k .'_'.$fld.'%#',  $answerr);
                       }
                       else {
                        
                        $answerr = preg_replace('/\b'.preg_quote($fld, '/').'\b/', $fld, $answerr);

                         }
                    }
                }


                $answerj = $quizz->addChild('Answer ', $answerr);
                $answerj->addAttribute('value', $prcntgg);

            }


            for ($i=1;$i<=$rows;$i++){
                $table_row = $quizz->addChild('Similar');
                $table_row->addAttribute('id', $i);
                for ($j=1;$j<=$cols;$j++){
                    $value = $_POST[ $i . 'f' . $j ];
                    $field = $table_row->addChild('Field ', $value);
                    $field->addAttribute('name', 'Field' . $j . ''); }
    
    
              }




            // Enregistrement du fichier XML
            $quizz->asXML("" . $bank . ".xml");

            // Message de confirmation
            echo ' <a href="' . $bank . '.xml" download>تم حفظ البيانات. حمّل الملف  </a> ';
        }
        ?>
                <!-------------------------------------------------html------------------------------------------------------------------------->

        <form method="post">
        
            <!--titre de l'interface-->
            <h1>توليد بنك أسئلة موودل يحتوي على أسئلة وأجوبة من نفس المستوى</h1>
         
            <!-------------------------------------------------------------------------->
            <!--choisir banc de question-->
            <div class="banc">
                <label for="banc" style="color: rgba(0, 0, 0, 15); font-size: 25px; " > اسم بنك الأسئلة  </label>
                <input type="text" style="width: 160pt;height: 17pt;" name="bank" id="bank" value="<?php  echo  $_SESSION['bank']; ?>"  placeholder="  اسم بنك الأسئلة">
            </div>
            <br>
            <br>
            <?php 
    if(isset($_POST['Generate'])) {
        $_SESSION['answer'] = $_POST['answer'];
        $_SESSION['rows'] = $_POST['rows'];
        $_SESSION['cols'] = $_POST['cols'];
    }
?>
    
       
             <!-------------------------------------------------------------------------->
            <!--une zone pour les question-->
            <label style="color: rgba(0, 0, 0, 15); font-size: 20px; " > خريطة الأسئلة </label><nav class="cadr">

            <div class="Q1">

                <label for="Question">نص السؤال</label>
                <input id="Question" type="text" name="Question"  onmouseup="copierMot()" value="<?php echo $_SESSION['Question']?>" placeholder=" نص السؤال">
                <label name="mark" for="mark1"> علامة</label> <input id=" mark1" type="number" min="0" max="20" name="mark" value="<?php echo $_SESSION['mark'] ?>" style="height: 20pt; width:  25pt;">
            </div>
            <br>

            <!-------------------------------------------------------------------------->
            <!--une zone poure les reponse-->
            <div class="R1" id="monFormulaire">
                <label for="answer1"> نص الإجابة  1</label>
                <input id="answer1" type="text" name="Reponse1" onmouseup="copierMot()" value="<?php echo $_SESSION['Reponse1']?>" placeholder="  نص الإجابة ">
                <label for="mark1"> ن.مئوية</label> <input id="mark1" type="text" name="prctg1" value="<?php echo $_SESSION['prctg1'] ?>" style="height: 20pt; width:  26pt;"><br>
                <br>
            </div>

            <!-------------------------------------------------------------------------------------->
             <!-------------------------------------------------------------------------------------->
       
            <!----------------php de generate  ----------------------->

            <?php 
            $answer = $_SESSION['answer'];
            $rows =  $_SESSION['rows'];
            $cols = $_SESSION['cols'];
            for ($j = 2; $j <= $answer; $j++) {
                $a=isset($_POST['Reponse' . $j]) ? $_POST['Reponse' . $j] : "";
                $a2=isset($_POST['prctg' . $j]) ? $_POST['prctg' . $j] : "100%";
                $value2 = isset($_SESSION['prctg' . $j]) ? $_SESSION['prctg' . $j] : $a2;
                $value = isset($_SESSION['Reponse' . $j]) ? $_SESSION['Reponse' . $j] : $a;
                echo '<label for="answer' . $j . '">نص الإجابة' . $j . '</label>';
                echo '<input id="answer' . $j . '" type="text" name="Reponse' . $j . '" value="' . $value . '" onmouseup="copierMot()" style="width: 300pt;height: 20pt;" placeholder=" نص الإجابة"> ';
                echo '<label for="mark' . $j . '">  ن.مئوية</label> ';
                echo '<input id="mark' . $j . '" type="text" name="prctg' . $j . '" value="' . $value2 . '" style="height: 20pt;width: 25pt;"><br>';
                echo '<br> ';
            }
            echo'</nav>';
            echo '<br>';
            echo '<br>';
                        
            ////////////////////////////////////////////////////////////////////////////////////////////////
            echo '<table border="1">';
            echo '<thead>';
            echo '<tr>';
            for ($j = 1; $j <= $cols; $j++) {
                echo '<th>الحقل' . $j . '</th>';
            }
            echo '<tr>';
            echo '</thead>';
                      
            for ($i = 0; $i < $rows; $i++) {
                $f = $i + 1;
        
                echo '<tr>';
                for ($j = 1; $j <= $cols; $j++) {
                    $g = $j - 1;
                    $v=isset($_POST[$f . 'f' . $j]) ? $_POST[$f . 'f' . $j] : "";
                    $val = isset($_SESSION['similar_'.$i.'_field_'.$g]) ? $_SESSION['similar_'.$i.'_field_'.$g] : $v;
                    echo '<td><input type="text" id="champCopie' . $i . '' . $j . '" value="'. $val.'" name="' . $f . 'f' . $j . '" class="td"></td>';
                                
                }
                echo '</tr>';
            }
            echo '</table>';
            echo '<br>';
        ?>
        </nav>
<!--------------nombre d'answer,fields,questions et botton generate  ----------------------->
    <!---------------nombre d'answer  ----------------------->
    <label for="answer">عدد الإجابات:</label>
    <input type="number" name="answer" id="answer" min="0" max="20" style="width: 40pt; height: 15pt;" value="<?php echo  $_SESSION['answer'] ?>" >

    <!---------------nombre de questions ----------------------->
    <label for="rows">عدد الأسئلة المشابهة:</label>
    <input type="number" name="rows" id="rows" min="0" max="20" style="width: 40pt; height: 15pt;" value="<?php echo  $_SESSION['rows'] ?>" >

    <!---------------nombre de fields ----------------------->
    <label for="cols">عدد الحقول  :</label>
    <input type="number" name="cols" id="cols" min="0" max="12" style="width: 40pt; height: 15pt;" value="<?php echo $_SESSION['cols'] ?>" >

    <!---------------button generate ----------------------->
    <input type="submit" name="Generate" value="توليد"  onmouseup="validerChamps(['cols', 'rows', 'answer'])" id="Generate">
       <br>
       <br> 

            <!-----------------------------------les 3 bottons---------------------------------->
            <br><br>


            <input type="button" value="إضافة نوع المحتوى" style="width: 100pt;height: 20pt; margin: 0px 35px;font-size: 2ch;background-color:#0f6fc5;color: #fff;">
            <input type="button" value="إدارة قائمة أنواع المحتوى" style="width: 115pt;height: 20pt; margin: 0px 35px;font-size: 2ch;background-color:#0f6fc5;color: #fff;">





            <!-----------------------------------table22---------------------------------->
            <br><br>
            <table id="myTable">
                <thead>
                    <tr>
                        <th>اسم الحقل</th>
                        <th>المحتوى الأصلي</th>
                        <th>نوع المحتوى</th>
                    </tr>
                </thead>
                <tbody class="tbl2">
                    <tr>
                        <td><input class="td" value="الحقل1"></td>
                        <td><input name="field1" id="champCopie1" value="<?php echo  isset( $_POST['1f1']) ? $_POST['1f1'] : ""; ?>" class="td"> </td>
                        <td><select id="langue" name="langue">
                                <option> محدد من قبل المعلم </option>
                                <option>عدد صحيح[0, 0]</option>
                                <option>عدد حقيقي[0.0, 0.0]</option>
                                <option>نوع  أساسي في جافا</option>
                                <option>عنوان بروتوكول الإنترنت بمضيف  مصنف</option>
                                <option>عنوان بروتوكول الإنترنت بمضيف غير مصنف</option>
                                <option> اسم الدولة</option>
                                <option> اسم الشخص </option>
                            </select> </td>
                    </tr>
                    <?php 
                        ////////////////////////////////////////////////////////////////

                        for ($i = 2; $i <= $cols; $i++) {
                            echo '<tr>';
                            for ($j = 1; $j <= 3; $j++) {

                                if ($j == 1) {
                                    echo '<td><input type="text" value="الحقل' . $i . '"   class="td"></td>';
                                }
                                $fff = isset( $_POST['1f' . $i]) ? $_POST['1f' . $i] : " " ;
                                if ($j == 2) {
                                    echo '<td><input type="text" value="'.$fff.'" name="field'.$i.'"  id="champCopie' . $i . '"   class="td"></td>';
                                }
                                if ($j == 3) {
                                    echo '<td><select id="langue" name="langue"><option>محدد من قبل المعلم </option><option>عدد صحيح[0, 0]</option><option>عدد حقيقي[0.0, 0.0]</option><option>نوع  أساسي في جافا</option><option>عنوان بروتوكول الإنترنت بمضيف مصنف</option><option>عنوان بروتوكول الإنترنت بمضيف غير مصنف</option><option> اسم الدولة </option><option>  اسم الشخص</option> </td>';
                                }
                            }
                            echo '</tr>';
                        } 
                    ?>
                </tbody>
            </table>

            <br>
            <br><br><br><br>

            <!-----------------------------------save---------------------------------->
            <input type="submit" class="save" value="حفظ" name="save" onmouseup="validerChamps(['bank','Question','answer1','mark1'])" style=" margin: 0px 35px;font-size: 2ch;background-color:#0f6fc5;color: #fff; width: 55pt;height: 17pt">

            <!-----------------------------------SAVEAS---------------------------------->
            <label for="saveass"> حفظ باسم:</label> <input type="text" name="saveass" id="inptAs" value="<?php echo isset($_POST['saveass']) ? $_POST['saveass'] : ''; ?>"  style="width: 60pt; height: 17pt; background-color :#f3f3f3; border: 0cm; " placeholder=" اسم المجلد"> <input type="submit" class="saveas" name="saveas" onmouseup="validerChamps(['bank','Question','answer1','mark1','inptAs'])" value="حفظ باسم: " style="  font-size: 2ch;background-color:#0f6fc5;color: #fff; width: 50pt;height: 17pt">

            <!-----------------------------------saveasmoodle--------------------------------->
            <input type="submit" name="saveasmoodle" onmouseup="validerChamps(['bank','Question','answer1','mark1'])" value="XML حفظ على شكل موودل " style="  margin: 0px 35px;font-size: 2ch;background-color:#0f6fc5;color: #fff; width: 130pt;height: 17pt">
                    </form>
                    <form method="post" action="load.php">
            <br> <br> <br>
            <!-----------------------------------LOAD---------------------------------->

            <label for="Laod ">تحميل:</label> <input type="text" name="laod" id="inputL" value="<?php echo isset($_POST['laod']) ? $_POST['laod'] : ''; ?>" style="width: 60pt; height: 17pt; background-color :#f3f3f3; border: 0cm; " placeholder=" اسم المجلد"> <input type="submit" name="Load" value="تحميل" onmouseup="validerChamps(['inputL'])" style=" font-size: 2ch;background-color:#0f6fc5;color: #fff; width: 50pt;height: 17pt">

            <!-----------------------------------new---------------------------------->

            <a href="pluginmoodleArab.php" target="_blank"> <input type="button" class="new" value="جديد" style=" margin: 0px 35px;font-size: 2ch;background-color:#0f6fc5;color: #fff; width: 55pt;height: 17pt"></a>

            <br><br>
        </form>

    </center>

    <script>
        //////////////////////////////////////java script//////////////////////////////////////////////////////////////////////////////
        function copierMot() {
            var numLines = parseInt(document.getElementById("cols").value);
            var zero = 1;
            
            var motSelectionne = window.getSelection().toString().trim();
            if (motSelectionne) {
                var confirmation = confirm("Do you want to copy the word  \"" + motSelectionne + " \" in the field ?");
                if (confirmation) {
                    zero++;
                    var compteur = 0;

                    for (let index = 1; index <= numLines; index++) {

                        const champId = document.getElementById("champCopie0" + index);
                        const champId1 = document.getElementById("champCopie" + index);
                        if (champId.value == '' ) {
                            compteur = index;

                            break;
                        }
                    }
                    if (compteur != 0) {
                        const champ = document.getElementById("champCopie0" + compteur);
                        const champ1 = document.getElementById("champCopie" + compteur);
                        champ.value = motSelectionne;
                        champ1.value = motSelectionne;
                    } else {
                        alert("The fields are filled  !");
                    }
                }
            }
        }
        function validerChamps(ids) {
      var valid = true;
      for (var i = 0; i < ids.length; i++) {
        var champNom = document.getElementById(ids[i]);
        if (champNom.value == "") {
          champNom.setCustomValidity("The field " + ids[i] + " is required");
          champNom.reportValidity();
          champNom.focus();
          valid = false;
        } else {
          champNom.setCustomValidity("");
        }
      }
      return valid;
    }
    </script>
</body>

</html>