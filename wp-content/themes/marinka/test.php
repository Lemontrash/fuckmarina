<?php
/*
Template Name: api
*/
//insertAll();
//exit();
class MMKSruct1 {
    public function __construct($a) {
        $i=0;
        foreach($a as $var=>$val) {
            $varName = 'in'.$i;
            $this->$varName = $val;
            $i++;
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<!--<form action="" method="get">-->
<!--    Max length:<input type="text" name="maxLength"> <br>-->
<!--    Min length: <input type="text" name="minLength"> <br>-->
<!--    Max price:<input type="text" name="maxPrice"> <br>-->
<!--    Min price:<input type="text" name="minPrice"> <br>-->
<!--    country:<input type="text" name="country"> <br>-->
<!--    yachtType:<input type="text" name="yachtType"> <br>-->
<!--    YEARBLYAT:<input type="text" name="YEARBLYAT"> <br>-->
<!--    Rooms:<input type="text" name="cabins"> <br>-->
<!--    Autopilot: <input type="checkbox" value="autopilot" name="options[]"> <br>-->
<!--    123: <input type="checkbox" value="123" name="options[]"> <br>-->
<!--    321: <input type="checkbox" value="321" name="options[]"> <br>-->
<!--    <button type="submit">!!!!!!!!!!!!</button>-->
<!--</form>-->
<form action="http://marinawp/yachts-by-date/" method="post">
    Max length:<input type="date" name="dateFrom"> <br>
    Min length: <input type="date" name="dateTo"> <br>
    country:<input type="text" name="country"> <br>
    <!--    suka:<input type="text" name="year"> <br>-->
    <button type="submit">!!!!!!!!!!!!</button>
</form>
<?php
if(isset($_GET['dateFrom']) || isset($_GET['dateTo']))
{
    $dateFrom = new DateTime($_GET['dateFrom']);
    $dateFrom = $dateFrom->format('Y.m.d H:i:s');
    $dateFrom =  str_replace(' ', 'T', $dateFrom);
    $dateFrom =  str_replace('.', '-', $dateFrom);

    $dateTo = new DateTime($_GET['dateTo']);
//    dd($dateTo);
    $dateTo = $dateTo->format('Y.m.d H:i:s');
    $dateTo =  str_replace(' ', 'T', $dateTo);
    $dateTo =  str_replace('.', '-', $dateTo);
    $dateFrom = $dateFrom.'.0000';
    $dateTo = $dateTo.'.0000';
    $args = [
        'dateFrom' => $dateFrom,
        'dateTo' => $dateTo,
        'country'  => $_GET['country'],
    ];

//    filtration($args);
}
//<?php
//if(isset($_GET['maxLength']) || isset($_GET['minLength']))
//{
//    $maxL = 9999999;
//    $minL = 0;
//    $maxPrice = 9999999;
//    $minPrice = 0;
//    $cabins = 0;
//
//    if (strlen($_GET['cabins'] != 0)){
//        $cabins = $_GET['cabins'];
//    }
//    if (strlen($_GET['maxLength']) != 0){
//        $maxL = $_GET['maxLength'];
//    }
//    if (strlen($_GET['minLength']) != 0){
//        $minL = $_GET['minLength'];
//    }
//    if (strlen($_GET['maxPrice']) != 0){
//        $maxPrice = $_GET['maxPrice'];
//    }
//    if (strlen($_GET['minPrice']) != 0){
//        $minPrice = $_GET['minPrice'];
//    }
//
//    $args = [
//        'maxLength' => $maxL,
//        'minLength' => $minL,
//        'maxPrice'  => $maxPrice,
//        'minPrice'  => $minPrice,
//        'cabins'    => $cabins,
//    ];
////    dd($args);
//
//    if (strlen($_GET['country']) != 0 &&
//        strlen($_GET['yachtType']) != 0 &&
//        strlen($_GET['YEARBLYAT']) != 0){
//
//        $args['country'] = $_GET['country'];
//        $args['yachtType'] = $_GET['yachtType'];
//        $args['YEARBLYAT'] = $_GET['YEARBLYAT'];
//    }
//    elseif (strlen($_GET['country']) != 0 &&
//        strlen($_GET['yachtType']) != 0){
//
//        $args['country'] = $_GET['country'];
//        $args['yachtType'] = $_GET['yachtType'];
//
//    }
//    elseif( strlen($_GET['yachtType']) != 0 &&
//        strlen($_GET['YEARBLYAT']) != 0){
//
//        $args['yachtType'] = $_GET['yachtType'];
//        $args['YEARBLYAT'] = $_GET['YEARBLYAT'];
//
//    }elseif ( strlen($_GET['YEARBLYAT']) != 0 &&
//        strlen($_GET['country']) != 0){
//
//        $args['country'] = $_GET['country'];
//        $args['YEARBLYAT'] = $_GET['YEARBLYAT'];
//
//    }elseif (strlen($_GET['YEARBLYAT']) != 0){
//        $args['YEARBLYAT'] = $_GET['YEARBLYAT'];
//    }elseif (strlen($_GET['country']) != 0){
//        $args['country'] = $_GET['country'];
//    }elseif(strlen($_GET['yachtType']) != 0){
//        $args['yachtType'] = $_GET['yachtType'];
//    }
//
//    filtration($args);
//}

//function filtration($arr){
//
//    $maxL = $arr['maxLength'];
//    $minL = $arr['minLength'];
//    $maxPrice = $arr['maxPrice'];
//    $minPrice = $arr['minPrice'];
//    $cabins = $arr['cabins'];
//    global $wpdb;
//    $table_name = $wpdb->get_blog_prefix() . 'yachts';
////    $locations = $wpdb->get_blog_prefix() . 'yachts_locations';
//    if (isset($arr['country']) && isset($arr['YEARBLYAT']) && isset($arr['yachtType'])){
//
//        $country = "'".$arr['country']."'";
//        $year = $arr['YEARBLYAT'];
//        $yachtType = "'".$arr['yachtType']."'";
//
//        $col = $wpdb->get_results("SELECT * FROM $table_name WHERE
//                    length < $maxL and length > $minL and
//                    price < $maxPrice and price > $minPrice and
//                    country_id = $country and year >= $year and kind = $yachtType
//                    and cabins >= $cabins");
//    }
//    elseif (isset($arr['YEARBLYAT']) && isset($arr['yachtType'])){
//
//        $year = $arr['YEARBLYAT'];
//        $yachtType = "'".$arr['yachtType']."'";
//
//        $col = $wpdb->get_results("SELECT * FROM $table_name WHERE
//                    length < $maxL and length > $minL and
//                    price < $maxPrice and price > $minPrice and
//                    year >= $year and kind = $yachtType and cabins >= $cabins");
//    }
//    elseif (isset($arr['country']) && isset($arr['yachtType'])){
//
//        $country = "'".$arr['country']."'";
//        $yachtType = "'".$arr['yachtType']."'";
//
//        $col = $wpdb->get_results("SELECT * FROM $table_name WHERE
//                    length < $maxL and length > $minL and
//                    price < $maxPrice and price > $minPrice and
//                    country_id = $country and kind = $yachtType and cabins >= $cabins");
//    }
//    elseif (isset($arr['country']) && isset($arr['YEARBLYAT'])){
//
//        $country = "'".$arr['country']."'";
//        $year = $arr['YEARBLYAT'];
//
//        $col = $wpdb->get_results("SELECT * FROM $table_name WHERE
//                    length < $maxL and length > $minL and
//                    price < $maxPrice and price > $minPrice and
//                    country_id = $country and year >= $year and cabins >= $cabins");
//    }
//    elseif (isset($arr['country'])){
//
//        $country = "'".$arr['country']."'";
//
//        $col = $wpdb->get_results("SELECT * FROM $table_name WHERE
//                    length < $maxL and length > $minL and
//                    price < $maxPrice and price > $minPrice
//                    and country_id = $country and cabins >= $cabins");
//    }elseif (isset($arr['YEARBLYAT'])){
//
//        $year = $arr['YEARBLYAT'];
//
//        $col = $wpdb->get_results("SELECT * FROM $table_name WHERE
//                    length < $maxL and length > $minL and
//                    price < $maxPrice and price > $minPrice
//                    and year >= $year and cabins >= $cabins");
//    }
//    elseif (isset($arr['yachtType'])){
//
//        $yachtType = "'".$arr['yachtType']."'";
//
//        $col = $wpdb->get_results("SELECT * FROM $table_name WHERE
//                    length < $maxL and length > $minL and
//                    price < $maxPrice and price > $minPrice
//                    and kind = $yachtType and cabins >= $cabins");
//    }
//    else{
//        $col = $wpdb->get_results("SELECT * FROM $table_name WHERE
//                    length < $maxL and length > $minL and
//                    price < $maxPrice and price > $minPrice and cabins >= $cabins");
//    }
//    $output = $col;
//    if (isset($_GET['options'])){
//        $TableOptions = $wpdb->get_blog_prefix() . 'options_for_yachts';
//        $options = $wpdb->get_results("select * from $TableOptions");
//        $output = [];
//        foreach ($col as $yacht){
//            foreach ($options as $option){
//                foreach ($_GET['options'] as $getOption) {
//                    if ($yacht->id == $option->yacht_id && $option->name = $getOption){
//                        $output[] = $yacht;
//                    }
//                }
//            }
//        }
//
//
//        foreach ($output as $key => $item) {
//            $output[$key] = json_decode(json_encode($item), true);
//        }
//        foreach ($output as $key => $item) {
//            $current = $output[$key];
//            $ass = $output[$key+1];
//
//            if ($current['id'] == $ass['id']){
//                unset($output[$key]);
//            }
//        }
//        $col = $output;
//    }
////    dd($col);
//    dd($output);
//}
//
//
?>
<?php
function filtration($arr){

    $maxL = $arr['maxLength'];
    $minL = $arr['minLength'];
    $maxPrice = $arr['maxPrice'];
    $minPrice = $arr['minPrice'];
    $cabins = $arr['cabins'];
    global $wpdb;
    $table_name = $wpdb->get_blog_prefix() . 'yachts';
//    $locations = $wpdb->get_blog_prefix() . 'yachts_locations';
    if (isset($arr['country']) && isset($arr['YEARBLYAT']) && isset($arr['yachtType'])){

        $country = "'".$arr['country']."'";
        $year = $arr['YEARBLYAT'];
        $yachtType = "'".$arr['yachtType']."'";

        $col = $wpdb->get_results("SELECT * FROM $table_name WHERE 
                    length < $maxL and length > $minL and 
                    price < $maxPrice and price > $minPrice and
                    country_id = $country and year >= $year and kind = $yachtType 
                    and cabins >= $cabins");
    }
    elseif (isset($arr['YEARBLYAT']) && isset($arr['yachtType'])){

        $year = $arr['YEARBLYAT'];
        $yachtType = "'".$arr['yachtType']."'";

        $col = $wpdb->get_results("SELECT * FROM $table_name WHERE 
                    length < $maxL and length > $minL and 
                    price < $maxPrice and price > $minPrice and 
                    year >= $year and kind = $yachtType and cabins >= $cabins");
    }
    elseif (isset($arr['country']) && isset($arr['yachtType'])){

        $country = "'".$arr['country']."'";
        $yachtType = "'".$arr['yachtType']."'";

        $col = $wpdb->get_results("SELECT * FROM $table_name WHERE 
                    length < $maxL and length > $minL and 
                    price < $maxPrice and price > $minPrice and 
                    country_id = $country and kind = $yachtType and cabins >= $cabins");
    }
    elseif (isset($arr['country']) && isset($arr['YEARBLYAT'])){

        $country = "'".$arr['country']."'";
        $year = $arr['YEARBLYAT'];

        $col = $wpdb->get_results("SELECT * FROM $table_name WHERE 
                    length < $maxL and length > $minL and 
                    price < $maxPrice and price > $minPrice and 
                    country_id = $country and year >= $year and cabins >= $cabins");
    }
    elseif (isset($arr['country'])){

        $country = "'".$arr['country']."'";

        $col = $wpdb->get_results("SELECT * FROM $table_name WHERE 
                    length < $maxL and length > $minL and 
                    price < $maxPrice and price > $minPrice 
                    and country_id = $country and cabins >= $cabins");
    }elseif (isset($arr['YEARBLYAT'])){

        $year = $arr['YEARBLYAT'];

        $col = $wpdb->get_results("SELECT * FROM $table_name WHERE 
                    length < $maxL and length > $minL and 
                    price < $maxPrice and price > $minPrice 
                    and year >= $year and cabins >= $cabins");
    }
    elseif (isset($arr['yachtType'])){

        $yachtType = "'".$arr['yachtType']."'";

        $col = $wpdb->get_results("SELECT * FROM $table_name WHERE 
                    length < $maxL and length > $minL and 
                    price < $maxPrice and price > $minPrice 
                    and kind = $yachtType and cabins >= $cabins");
    }
    else{
        $col = $wpdb->get_results("SELECT * FROM $table_name WHERE 
                    length < $maxL and length > $minL and 
                    price < $maxPrice and price > $minPrice and cabins >= $cabins");
    }
    $output = $col;
    if (isset($_GET['options'])){
        $TableOptions = $wpdb->get_blog_prefix() . 'options_for_yachts';
        $options = $wpdb->get_results("select * from $TableOptions");
        $output = [];
        foreach ($col as $yacht){
            foreach ($options as $option){
                foreach ($_GET['options'] as $getOption) {
                    if ($yacht->id == $option->yacht_id && $option->name = $getOption){
                        $output[] = $yacht;
                    }
                }
            }
        }


        foreach ($output as $key => $item) {
            $output[$key] = json_decode(json_encode($item), true);
        }
        foreach ($output as $key => $item) {
            $current = $output[$key];
            $ass = $output[$key+1];

            if ($current['id'] == $ass['id']){
                unset($output[$key]);
            }
        }
        $col = $output;
    }
//    dd($col);
    dd($output);
}

?>
</body>
</html>