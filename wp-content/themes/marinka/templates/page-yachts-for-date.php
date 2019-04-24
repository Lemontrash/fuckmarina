<?php
/* Template Name: Yacht Date Search */
get_header();
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
$dateFrom = new DateTime($_POST['dateFrom']);
$dateFrom = $dateFrom->format('Y.m.d H:i:s');
$dateFrom =  str_replace(' ', 'T', $dateFrom);
$dateFrom =  str_replace('.', '-', $dateFrom);

$dateTo = new DateTime($_POST['dateTo']);
//    dd($dateTo);
$dateTo = $dateTo->format('Y.m.d H:i:s');
$dateTo =  str_replace(' ', 'T', $dateTo);
$dateTo =  str_replace('.', '-', $dateTo);
$dateFrom = $dateFrom.'.0000';
$dateTo = $dateTo.'.0000';

global $wpdb;
$name = $_POST['country'];
$validCountry = $wpdb->get_results("select * from wp_yachts_countries where name = '$name'");
$id = $validCountry[0]->id;
$code = $validCountry[0]->shortname;
$locations = $wpdb->get_results("select * from wp_yachts_locations where country_id = '$id'");

$filters = "
<filter>
     <element id=\"datefrom\">$dateFrom</element> 
     <element id=\"dateto\">$dateTo</element>
     <element id=\"flexibility\">6</element>
</filter>";

$test = " <filter><element id=\"datefrom\">$dateFrom</element><element id=\"dateto\">$dateTo</element><element id=\"flexibility\">6</element><element id=\"countrycodes\">$code</element></filter>";

$wsdl = 'http://www.booking-manager.com/cbm_web_service2/services/CBM?wsdl';

$soapClient = new SoapClient($wsdl, Array('trace'=>1));

try {
    $struct = new MMKSruct1(Array(3497,'office@sea-time.co.il','seatime0',$test));

    $result = $soapClient->getSearchResultsFilter($struct);

    if (isset($result->out)) {
        $xml = $result->out;
        echo $xml;
    }
}

catch (Exception $e) {
    print_r($soapClient->__getLastRequest());
    print_r($soapClient->__getLastResponse());
    print_r($e->getTrace());
    var_dump($e);
}
$tmp = $soapClient->__getLastResponse();
$response = html_entity_decode($tmp);
$response = stristr($response, '<root>');
$pos = strpos($response, '</ns1:out>');
$response = substr($response, 0, $pos);
$obj = new SimpleXMLElement($response);
//dd($obj);
$counter = 0;
$sc = 0;
foreach ($obj as $item) {
//    dd($item);
    if ((string)$item->attributes()['reservationstatus'] == 0 && $counter < 400){
        $ids[] = (string)$item->attributes()['resourceid'];
        $counter++;
        $ids = array_unique($ids);
    }

}

foreach ($ids as $id) {
    try {
        $struct = new MMKSruct1(Array(3497,'office@sea-time.co.il','seatime0',$id));

        $result = $soapClient->getResourceDetails($struct);

        if (isset($result->out)) {
            $xml = $result->out;
            echo $xml;
        }
    }

    catch (Exception $e) {
        print_r($soapClient->__getLastRequest());
        print_r($soapClient->__getLastResponse());
        print_r($e->getTrace());
        var_dump($e);
    }
    $tmp = $soapClient->__getLastResponse();
    $response = html_entity_decode($tmp);
    $response = stristr($response, '<root>');
    $pos = strpos($response, '</ns1:out>');
    $response = substr($response, 0, $pos);

    $objects[] = new SimpleXMLElement($response);
}
//dd($objects);
$objectForView = [];
$counter = 0;
foreach ($objects as $object) {
//    foreach ($object->resource->attributes() as $attribute) {
//
//    }
    $objectForView[$counter]["id"] = (string)$object->resource->attributes()['id'];
    $objectForView[$counter]["model"] = (string)$object->resource->attributes()['model'];
    $objectForView[$counter]["berths"] = (string)$object->resource->attributes()['berths'];
    $objectForView[$counter]["length"] = (string)$object->resource->attributes()['length'];
    $objectForView[$counter]["cabins"] = (string)$object->resource->attributes()['cabins'];
    $objectForView[$counter]["heads"] = (string)$object->resource->attributes()['heads'];
    $objectForView[$counter]["engine"] = (string)$object->resource->attributes()['engine'];
    $objectForView[$counter]["price"] = (string)$object->resource->attributes()['deposit'];
    foreach ($object->resource->images as $image){
        foreach ($image as $fuckMe){
            $images[] = (string)$fuckMe->attributes()['href'];
        }
        $objectForView[$counter]["images"] = $images;
        unset($images);
    }
    $counter++;
}


?>
<style>
    .SBSidebar{
        width: 20%;
        display: inline-flex;
        flex-direction: column;
        align-items: flex-start;
    }
    .SearchBlock{
        display: flex;
    }
    .ProductItem{
        -webkit-box-shadow: -1px 2px 25px 5px rgba(0,0,0,0.64);
        -moz-box-shadow: -1px 2px 25px 5px rgba(0,0,0,0.64);
        box-shadow: -1px 2px 25px 5px rgba(0,0,0,0.64);
    }
    .SBSidebar{
        -webkit-box-shadow: -1px 2px 25px 5px rgba(0,0,0,0.64);
        -moz-box-shadow: -1px 2px 25px 5px rgba(0,0,0,0.64);
        box-shadow: -1px 2px 25px 5px rgba(0,0,0,0.64);
    }
    .ProductItem{
        display: flex;
        width: 20%;
    }
    .ProductsWrapper{
        width: 100%;
    }
</style>


<?php

get_header();
?>

<style>


    .SBTxtHeading {
        color: black;
        font-family: 'Rubik',sans-serif;
        text-transform: uppercase;
        font-size: 35px;
        font-weight: 700;
        margin-top: 1%;
        margin-bottom: 3%;
    }
    .SBSidebar{
        width: 30%;
        margin-right: auto;
        margin-top: -5%;
        margin-bottom: 5%;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        -webkit-box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        -moz-box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }
    .SearchBlock{
        display: flex;
        margin: 0 auto;
        width: 85%;
        height: auto;
        flex-wrap: wrap;
        padding-top: 4%;
        position: relative;
    }

    .ProductItem{
        display: flex;
        flex-direction: column;
        width: 30%;
        margin-right: auto;
        margin-bottom: 5%;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        -webkit-box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        -moz-box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }
    .ProductItem .slick-dotted.slick-slider{
        margin-bottom: 0;
    }
    .FilterRow{
        display: flex;
        flex-direction: column;
        position: absolute;
        width: 70%;
        top: 0;
        left: 34%;
    }
    .SingleFilter{
        display: flex;
        width: 18%;
        justify-content: space-between;
        align-items: center;
    }
    .ProductsWrapper{
        width: 100%;
    }
    .PItemOptions{
        width: 100%;
        height: 100%;
        padding: 5%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .SidebarInputs{
        display: flex;
        flex-direction: column;
        width: 100%;
        height: 100%;
        padding: 5%;
    }
    .SidebarButtonRow{
        display: flex;
        justify-content: center;
    }
    .SidebarButtonRow input{
        width: 35%;
        padding: 2% 0;
        background-color: #1d9fb3;
        color: white;
        border: none;
    }
    .SidebarInputName{
        direction: ltr;
        padding-bottom: 2%;
    }
    .SidebarTypeBlock input{
        width: 100%
    }
    .slider.slider-horizontal .tooltip {
        -ms-transform: none;
        transform: none;
        text-align: center;
    }
    aside {
        margin-right: 0;
    }
    .aboutus_wrapper.first {
        height: auto;
    }
    .SidebarSelectBlock {
        display: flex;
        flex-direction: column;
        padding-bottom: 6%;
    }
    .SidebarTypeBlock{
        display: flex;
        flex-direction: column;
    }
    .slider.slider-horizontal {
        width: 100%;
        height: 20px;
    }
    .SidebarTypeBlock{
        display: flex;
        flex-direction: column;
        padding-bottom: 5%;
    }
    .SidebarFacillyBlock{
        display: flex;
        flex-direction: column;
        padding-bottom: 5%;
    }
    .SidebarFacillyOptions {
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
    }

    .SidebarFacillyColumn{
        display: flex;
        flex-direction: column;
    }
    .SidebarFacillyColumn label{
        direction: ltr;
        color: black;
        padding-bottom: 7%;
    }

    .PItemSlider .slick-prev{
        left: 15px;
        z-index: 1;
    }
    .PItemSlider .slick-next{
        right: 15px;
        z-index: 1;
    }
    .PItemSlider .slick-dots{
        bottom: 20px;
    }
    .PItemSlider .slick-dots li button:before{
        font-size: 11px;
        color: white;
    }
    .PItemSlider .slick-next:before{
        font-family: Font Awesome\ 5 Pro;
        font-size: 30px;
        content: '\f0da';
        opacity: 1;
        color: white;
    }
    .PItemSlider .slick-prev:before{
        font-family: Font Awesome\ 5 Pro;
        font-size: 30px;
        content: '\f0d9';
        opacity: 1;
        color: white;
    }
    .PIOHeadingBlock{
        display: flex;
        flex-direction: column;
    }
    .PIOName{
        font-weight: 600;
        color: black;
    }
    .PIOHr{
        margin-bottom: 0;
        width: 20%;
        display: flex;
        margin: 0;
        background-color: #1d9fb3;
        height: 3px;
    }
    .PIOExcerpt{
        padding: 4% 0;
        display: flex;
    }
    .PIOValue, .FilterValue{
        color: #25a2b6;
    }
    .PIOLength, .PIORooms, .PIOHeadingBlock{
        padding-bottom: 4%;
    }
    .PIOPrice{
        padding-top: 4%;
        width: 53%;
        display: flex;
        justify-content: space-between;
    }
    .PIOLowerOptions{
        display: flex;
        justify-content: space-between;
        width: 52%;
        padding-bottom: 4%;
    }
    .SidebarFacillyOptions label{
        width: 50%;
        margin-bottom: 2%;
    }
    /*.SidebarFacillyColumn [type="checkbox"]{
        display: none;
    }

    .SidebarFacillyColumn label:before {
            content: "";
        display: inline-block;
        width: 16px;
        height: 16px;
        margin-right: 10px;
        position: absolute;
        left: 0;
        bottom: 1px;
        background-color: #aaa;
        box-shadow: inset 0px 2px 3px 0px rgba(0, 0, 0, .3), 0px 1px 0px 0px rgba(255, 255, 255, .8);
        border: 1px solid black;
        border-radius: 3px;
    }
    .SidebarFacillyColumn input[type=checkbox]:checked + .SidebarFacillyColumn label:before {
        content: "\2713";
        text-shadow: 1px 1px 1px rgba(0, 0, 0, .2);
        font-size: 15px;
        color: #f3f3f3;
        text-align: center;
        line-height: 15px;
    }*/
    .FilterRowName{
        direction: ltr;
    }
    .SidebarFacillyOptions label input {
        display: none;/* <--скрываем дефолтный чекбокс */
    }
    .SidebarFacillyOptions label span {/* <-- стилизируем новый */
        height: 16px;
        width: 16px;
        margin-right: 5px;
        border: 2px solid #1d9fb3;
        display: inline-block;
        position: relative;
        border-radius: 2px;
        padding: 2px;
    }
    .SidebarFacillyOptions [type=checkbox]:checked + span:before {/* <-- ставим иконку, когда чекбокс включен  */
        content: '\f00c';
        display: flex;
        align-items: center;
        font-family: Font Awesome\ 5 Pro;
        position: absolute;
        height: 15px;
        background-color: #1d9fb3;
        top: -2px;
        left: -1px;
        font-size: 14px;
        color: white;
    }
    .SidebarFacillyOptions [type=checkbox]:checked{
        background-color: #1d9fb3;
    }
    .tooltip-max, .tooltip-min{
        display: none;
    }

</style>

<div class="aboutus_wrapper first">
    <h2 class="SBTxtHeading">Yacht Search</h2>
    <div class="SearchBlock">

        <div class="FilterRow">
            <div class="SingleFilter">
            </div>

        </div>
        <?php

        foreach ($objectForView as $yacht) {
            ?>
            <div class="ProductItem">
                <div class="PItemImages">
                    <div class="PItemSlider">
                        <?php
                        foreach ($yacht['images'] as $image) {
                            ?> <img src="<?= $image?>" class="PISliderItem"><?php
                        }
                        ?>

                    </div>
                </div>
                <div class="PItemOptions">
                    <div class="PIOHeadingBlock">
                        <span class="PIOName"></span>
                        <span class="PIOLocation"></span>
                    </div>
                    <hr class="PIOHr">
                    <span class="PIOExcerpt">!!!!!!!!</span>
                    <div class="PIOLowerBlock">
                        <div class="PIOLength"><span class="PIOValue"></span> m</div>
                        <div class="PIORooms"><span class="PIOValue"></span> rooms</div>
                        <hr class="PIOHr">
                        <span class="PIOPrice">Price per day: <span class="PIOValue"></span></span>
                    </div>
                </div>
            </div>
            <?php } ?>

    </div>
</div>
<?php
get_footer();
?>