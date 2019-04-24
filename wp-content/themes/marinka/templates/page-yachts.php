<?php
/* Template Name: Yacht Search */
get_header();
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
/* Template Name: Yacht Search */
get_header();
if(isset($_GET['length']) || isset($_GET['price']))
{
    $maxL = 9999999;
    $minL = 0;
    $maxPrice = 9999999;
    $minPrice = 0;
    $cabins = 0;

    if (strlen($_GET['room'] != 0)){
        $cabins = $_GET['room'];
    }
    if (strlen($_GET['price']) != 0){
        $arr = explode(',', $_GET['price']);
        $minPrice = $arr[0];
        $maxPrice = $arr[1];
    }
    if (strlen($_GET['length']) != 0){
        $arr = explode(',', $_GET['length']);
        $minL = $arr[0];
        $maxL = $arr[1];
    }


    $args = [
        'maxLength' => $maxL,
        'minLength' => $minL,
        'maxPrice'  => $maxPrice,
        'minPrice'  => $minPrice,
        'cabins'    => $cabins,
    ];

    if (strlen($_GET['countrySelect']) != 0 &&
        strlen($_GET['typeSelect']) != 0 &&
        strlen($_GET['year-true']) != 0){

        $args['countrySelect'] = $_GET['countrySelect'];
        $args['typeSelect'] = $_GET['typeSelect'];
        $args['year-true'] = $_GET['year-true'];
    }
    elseif (strlen($_GET['countrySelect']) != 0 &&
        strlen($_GET['typeSelect']) != 0){

        $args['countrySelect'] = $_GET['countrySelect'];
        $args['typeSelect'] = $_GET['typeSelect'];

    }
    elseif( strlen($_GET['typeSelect']) != 0 &&
        strlen($_GET['year-true']) != 0){

        $args['typeSelect'] = $_GET['typeSelect'];
        $args['year-true'] = $_GET['year-true'];

    }elseif ( strlen($_GET['year-true']) != 0 &&
        strlen($_GET['countrySelect']) != 0){

        $args['countrySelect'] = $_GET['countrySelect'];
        $args['year-true'] = $_GET['year-true'];

    }elseif (strlen($_GET['year-true']) != 0){
        $args['year-true'] = $_GET['year-true'];
    }elseif (strlen($_GET['countrySelect']) != 0){
        $args['countrySelect'] = $_GET['countrySelect'];
    }elseif(strlen($_GET['typeSelect']) != 0){
        $args['typeSelect'] = $_GET['typeSelect'];
    }

    $yachtsForDisplay = filtration($args);
}
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
    if (isset($arr['countrySelect']) && isset($arr['year-true']) && isset($arr['typeSelect'])){

        $country = "'".$arr['countrySelect']."'";
        $year = $arr['year-true'];
        $yachtType = "'".$arr['typeSelect']."'";
//        $col = 123;
        $col = $wpdb->get_results("SELECT * FROM $table_name WHERE 
                    length < $maxL and length > $minL and 
                    price < $maxPrice and price > $minPrice and
                    country_id = $country and year >= $year and kind = $yachtType 
                    and cabins >= $cabins");
    }
    elseif (isset($arr['year-true']) && isset($arr['typeSelect'])){

        $year = $arr['year-true'];
        $yachtType = "'".$arr['typeSelect']."'";

        $col = $wpdb->get_results("SELECT * FROM $table_name WHERE 
                    length < $maxL and length > $minL and 
                    price < $maxPrice and price > $minPrice and 
                    year >= $year and kind = $yachtType and cabins >= $cabins");
    }
    elseif (isset($arr['countrySelect']) && isset($arr['typeSelect'])){

        $country = "'".$arr['countrySelect']."'";
        $yachtType = "'".$arr['typeSelect']."'";

        $col = $wpdb->get_results("SELECT * FROM $table_name WHERE 
                    length < $maxL and length > $minL and 
                    price < $maxPrice and price > $minPrice and 
                    country_id = $country and kind = $yachtType and cabins >= $cabins");
    }
    elseif (isset($arr['countrySelect']) && isset($arr['year-true'])){

        $country = "'".$arr['countrySelect']."'";
        $year = $arr['year-true'];

        $col = $wpdb->get_results("SELECT * FROM $table_name WHERE 
                    length < $maxL and length > $minL and 
                    price < $maxPrice and price > $minPrice and 
                    country_id = $country and year >= $year and cabins >= $cabins");
    }
    elseif (isset($arr['countrySelect'])){

        $country = "'".$arr['countrySelect']."'";

        $col = $wpdb->get_results("SELECT * FROM $table_name WHERE 
                    length < $maxL and length > $minL and 
                    price < $maxPrice and price > $minPrice 
                    and country_id = $country and cabins >= $cabins");
    }elseif (isset($arr['year-true'])){
        $year = $arr['year-true'];
        $col = $wpdb->get_results("SELECT * FROM $table_name WHERE 
                    length < $maxL and length > $minL and 
                    price < $maxPrice and price > $minPrice 
                    and year >= $year and cabins >= $cabins");
    }
    elseif (isset($arr['typeSelect'])){

        $yachtType = "'".$arr['typeSelect']."'";

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
    if (isset($_GET['options'])){
        $TableOptions = $wpdb->get_blog_prefix() . 'options_for_yachts';
        $options = $wpdb->get_results("select * from $TableOptions");
        $output = [];
        $counter = 0;
//        foreach ($col as $yacht){
//            foreach ($options as $option){
//                foreach ($_GET['options'] as $getOption) {
//                    $innerCounter = 0;
//                    if ($yacht->id == $option->yacht_id && $option->name = $getOption){
//                        if ($option->id == 9){
//                            echo $option->id.'<br>'.$option->name;
//                        }
//                        $output[] = $yacht;
//                        $counter++;
//                    }
//                    if ($counter > 0){
//                        foreach ($output as $key => $out){
//                            if ($out->id == $yacht->id){
//                                if ($innerCounter == 0){
//                                    $innerCounter++;
//                                }else{
//                                    unset($output[$key]);
//                                }
//                            }
//                        }
//                    }
//                }
//                $counter = 0;
//            }
//        }

        foreach ($_GET['options'] as $option) {
            $singleOption = $wpdb->get_results("select * from wp_options_for_yachts where name = '$option'");
            foreach ($singleOption as $single){
                foreach ($col as $yacht) {
                    if ($yacht->id == $single->yacht_id && !in_array($yacht, $output)){
                        $output[] = $yacht;
                    }
                }
            }
        }
//dd($_GET['options']);

        foreach ($_GET['options'] as $option) {
            foreach ($output as $key => $out) {
                if (!$wpdb->get_results("select * from wp_options_for_yachts where yacht_id = $out->id and name = '$option' ")){
                    unset($output[$key]);
                }
            }
        }
//        dd($output);

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
    return $col;
}

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
        <?php
            if (empty($_GET)){
                ?>
                <aside class="SBSidebar">
            <form action="" class="SidebarInputs">
                <div class="SidebarSelectBlock">
                    <p class="SidebarInputName">Country</p>
                    <?php
                    global $wpdb;
                    $tableName = $table_name = $wpdb->get_blog_prefix() . 'yachts_countries';
                    $locations = $wpdb->get_results("select * from $tableName order by name ASC");
                    ?>
                    <select name="countrySelect" size="1">
                        <option value="">Select Country</option>
                        <?php
                        foreach ($locations as $location) {
                            ?><option value="<?= $location->name?>"><?= $location->name?></option><?php
                        }
                        ?>
                    </select>
                </div>

                <div class="SidebarSelectBlock">
                    <p class="SidebarInputName">Yacht type</p>
                    <?php
                    $tableName = $table_name = $wpdb->get_blog_prefix() . 'yachts';
                    $yachts = $wpdb->get_results("select * from $tableName ");
                    foreach ($yachts as $yacht) {
                        $types[] = $yacht->kind;
                    }
                    $types = array_unique($types);
                    ?>
                    <select name="typeSelect" size="1">
                        <option value="">Select Type</option>
                        <?php
                        foreach ($types as $type) {
                            ?><option value="<?= $type?>"><?= $type?></option><?php
                        }
                        ?>
                    </select>
                </div>

                <div class="SidebarTypeBlock">
                    <p class="SidebarInputName">Length</p>
                    <input id="LengthInput" type="text" name="length" class="span2" value="" data-provide="slider" data-slider-min="5" data-slider-max="25" data-slider-step="0.1" data-slider-value="[5,25]"/>
                </div>

                <div class="SidebarTypeBlock">
                    <p class="SidebarInputName">Price</p>
                    <input id="PriceInput" type="text" name="price" class="span2" value="" data-provide="slider" data-slider-min="500" data-slider-max="6000" data-slider-step="50" data-slider-value="[500,6000]"/>
                </div>

                <div class="SidebarTypeBlock">
                    <p class="SidebarInputName">Rooms</p>
                    <input type="number" size="3" name="room" min="1" max="10" value="1">
                </div>

                <div class="SidebarTypeBlock">
                    <p class="SidebarInputName">Year</p>
                    <input type="number" size="3" name="year-true" min="1980" max="2019" value="1980">
                </div>

                <div class="SidebarFacillyBlock">
                    <p class="SidebarInputName">Facilly</p>
                    <div class="SidebarFacillyOptions">
                        <?php
                        $tableName = $table_name = $wpdb->get_blog_prefix() . 'options_for_yachts';
                        $options = $wpdb->get_results("select * from $tableName");
                        foreach ($options as $option) {
                            $opt[] = $option->name;
                        }
                        $opt = array_unique($opt);
                        ?>

                        <?php
                            foreach ($opt as $item) {
                            ?><label for="<?= $item ?>"><input id="<?= $item ?>" type="checkbox" name="options[]" value="<?= $item ?>"><span></span><?= $item ?></label><?php
                            }
                            ?>
                    </div>
                </div>
                <div class="SidebarButtonRow">
                    <input class="SidebarButton" type="submit" value="Send">
                </div>
            </form>
        </aside>

                <?
            }
        else{
            ?>
            <aside class="SBSidebar">
                <form action="" class="SidebarInputs">
                    <div class="SidebarSelectBlock">
                        <p class="SidebarInputName">Country</p>
                        <?php
                        global $wpdb;
                        $tableName = $table_name = $wpdb->get_blog_prefix() . 'yachts_countries';
                        $locations = $wpdb->get_results("select * from $tableName order by name ASC");
                        ?>
                        <select name="countrySelect" size="1">
                            <option value="">Select Country</option>
                            <?php
                            foreach ($locations as $location) {
                                ?><option value="<?= $location->name?>"><?= $location->name?></option><?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="SidebarSelectBlock">
                        <p class="SidebarInputName">Yacht type</p>
                        <?php
                        $tableName = $table_name = $wpdb->get_blog_prefix() . 'yachts';
                        $yachts = $wpdb->get_results("select * from $tableName ");
                        foreach ($yachts as $yacht) {
                            $types[] = $yacht->kind;
                        }
                        $types = array_unique($types);
                        ?>
                        <select name="typeSelect" size="1">
                            <option value="">Select Type</option>
                            <?php
                            foreach ($types as $type) {
                                ?><option value="<?= $type?>"><?= $type?></option><?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="SidebarTypeBlock">
                        <p class="SidebarInputName">Length</p>
                        <?php
                        if (!empty($_GET['length'])){
                            $gets = explode(',', $_GET['length']);
                            ?>
                            <input id="LengthInput" type="text" name="length" class="span2" value="<?= $gets[0].','.$gets[1]?>" data-provide="slider" data-slider-min="5" data-slider-max="25" data-slider-step="0.1" data-slider-value="[<?= $gets[0].','.$gets[1]?>]"/>
                            <?php
                        }
                        ?>

                    </div>

                    <div class="SidebarTypeBlock">
                        <p class="SidebarInputName">Price</p>
                        <?php
                        if (!empty($_GET['price'])){
                            $gets = explode(',', $_GET['price']);
                            ?>
                            <input id="PriceInput" type="text" name="price" class="span2" value="<?= $gets[0].','.$gets[1]?>" data-provide="slider" data-slider-min="500" data-slider-max="6000" data-slider-step="50" data-slider-value="[<?= $gets[0].','.$gets[1]?>]"/>
                            <?php
                        }
                        ?>
<!--                        <input id="PriceInput" type="text" name="price" class="span2" value="" data-provide="slider" data-slider-min="500" data-slider-max="6000" data-slider-step="50" data-slider-value="[500,6000]"/>-->
                    </div>

                    <div class="SidebarTypeBlock">
                        <p class="SidebarInputName">Rooms</p>
                        <?php
                        if (!empty($_GET['room'])){
                            ?>
                            <input type="number" size="3" name="room" min="1" max="10" value="<?= $_GET['room'] ?>">
                            <?php
                        }else {
                            ?> <input type="number" size="3" name="room" min="1" max="10" value="1"><?php
                        }
                        ?>
                    </div>

                    <div class="SidebarTypeBlock">
                        <p class="SidebarInputName">Year</p>
                        <?php
                        if (!empty($_GET['year-true'])){
                            ?>
                            <input type="number" size="3" name="year-true" min="1980" max="2019" value="<?= $_GET['year-true'] ?>">
                            <?php
                        }else {
                            ?> <input type="number" size="3" name="year-true" min="1980" max="2019" value="1980"><?php
                        }
                        ?>

                    </div>

                    <div class="SidebarFacillyBlock">
                        <p class="SidebarInputName">Facilly</p>
                        <div class="SidebarFacillyOptions">
                            <?php
                            $tableName = $table_name = $wpdb->get_blog_prefix() . 'options_for_yachts';
                            $options = $wpdb->get_results("select * from $tableName");
                            foreach ($options as $option) {
                                $opt[] = $option->name;
                            }
                            $opt = array_unique($opt);
                            ?>

                            <?php
                            if (!empty($_GET['options'])){
                                $tmp = sizeof($_GET['options']);
                            }
//                            var_dump($_GET['options']);

                            $flag = 0;
                            foreach ($opt as $item) {
                                if (!empty($_GET['options'])){
                                    for($i = 0; $i < $tmp; $i++){
                                        if ($_GET['options'][$i] == $item){
                                            ?> <label for="<?= $item ?>"><input id="<?= $item ?>" type="checkbox" checked name="options[]" value="<?= $item ?> "><span></span><?= $item ?></label> <?php
                                            $flag = 1;
                                        }
                                    }
                                    if ($flag == 0){
                                        ?> <label for="<?= $item ?>"><input id="<?= $item ?>" type="checkbox" name="options[]" value="<?= $item ?>"><span></span><?= $item ?></label><?php
                                    }
                                    $flag = 0;
                                }else{
                                    ?> <label for="<?= $item ?>"><input id="<?= $item ?>" type="checkbox" name="options[]" value="<?= $item ?>"><span></span><?= $item ?></label><?php
                                }
                                ?><?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="SidebarButtonRow">
                        <input class="SidebarButton" type="submit" value="Send">
                    </div>
                </form>
            </aside>
            <?php
        }


        ?>


        <div class="FilterRow">
            <div class="SingleFilter">
<!--                <p class="FilterRowName">Result for:</p>-->
<!--                <select name="locationFilterSelect" size="1">-->
<!--                    <option value="Ibiza">Ibiza</option>-->
<!--                    <option value="England">England</option>-->
<!--                    <option value="Europe">Europe</option>-->
<!--                    <option value="America">America</option>-->
<!--                </select>-->
            </div>

        </div>

        <?php
        if (!$_GET){
            global $wpdb;
            $all = $wpdb->get_results("select * from wp_yachts");
            $images = $wpdb->get_results("select * from wp_images_for_yachts");
            foreach ($all as $yacht) {
                ?>

                <div class="ProductItem">
                    <div class="PItemImages">
                        <div class="PItemSlider">
                            <?php
                            foreach ($images as $image) {
                                if ($image->yacht_id == $yacht->id) {
                                    ?><img src="<?= $image->image ?>" class="PISliderItem"><?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <div class="PItemOptions">
                        <div class="PIOHeadingBlock">
                            <span class="PIOName"><?=$yacht->yacht_name ?></span>
                            <span class="PIOLocation"><?=$yacht->country_id ?></span>
                        </div>
                        <hr class="PIOHr">
                        <span class="PIOExcerpt">!!!!!!!!</span>
                        <div class="PIOLowerBlock">
                            <div class="PIOLength"><span class="PIOValue"><?=$yacht->length ?></span> m</div>
                            <div class="PIORooms"><span class="PIOValue"><?=$yacht->cabins ?></span> rooms</div>
                            <hr class="PIOHr">
                            <span class="PIOPrice">Price per day: <span class="PIOValue"><?=$yacht->price ?>$</span></span>
                        </div>
                    </div>
                </div>

                <?php
            }

        }
        else{
            if (is_array($yachtsForDisplay[0])){
                foreach ($yachtsForDisplay as $yacht) {
                    ?>
                    <div class="ProductItem">
                        <div class="PItemImages">
                            <?php
                            //                        dd($_GET['options']);
                            $id = $yacht['id'];
                            $images = $wpdb->get_results("select * from wp_images_for_yachts where yacht_id = $id");
                            ?>
                            <div class="PItemSlider">
                                <?php
                                foreach ($images as $image) {
                                    ?><img src="<?= $image->image ?>" class="PISliderItem"><?php
                                }
                                ?>
                            </div>
                        </div>
                        <div class="PItemOptions">
                            <div class="PIOHeadingBlock">
                                <span class="PIOName"><?=$yacht['yacht_name']?></span>
                                <span class="PIOLocation"><?=$yacht['country_id']?></span>
                            </div>
                            <hr class="PIOHr">
                            <span class="PIOExcerpt">!!!!!!!!</span>
                            <div class="PIOLowerBlock">
                                <div class="PIOLength"><span class="PIOValue"><?=$yacht['length']?></span> m</div>
                                <div class="PIORooms"><span class="PIOValue"><?=$yacht['cabins']?></span> rooms</div>
                                <hr class="PIOHr">
                                <span class="PIOPrice">Price per day: <span class="PIOValue"><?=$yacht['price']?>$</span></span>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }else{
                foreach ($yachtsForDisplay as $yacht) {
                    ?>
                    <div class="ProductItem">
                        <div class="PItemImages">
                            <?php
                                $images = $wpdb->get_results("select * from wp_images_for_yachts where yacht_id = $yacht->id");
                            ?>
                            <div class="PItemSlider">
                                <?php
                                foreach ($images as $image) {
                                        ?><img src="<?= $image->image ?>" class="PISliderItem"><?php
                                }
                                ?>
                            </div>
                        </div>
                        <div class="PItemOptions">
                            <div class="PIOHeadingBlock">
                                <span class="PIOName"><?=$yacht->yacht_name ?></span>
                                <span class="PIOLocation"><?=$yacht->country_id ?></span>
                            </div>
                            <hr class="PIOHr">
                            <span class="PIOExcerpt">!!!!!!!!</span>
                            <div class="PIOLowerBlock">
                                <div class="PIOLength"><span class="PIOValue"><?=$yacht->length ?></span> m</div>
                                <div class="PIORooms"><span class="PIOValue"><?=$yacht->cabins ?></span> rooms</div>
                                <hr class="PIOHr">
                                <span class="PIOPrice">Price per day: <span class="PIOValue"><?=$yacht->price ?>$</span></span>
                            </div>
                        </div>
                    </div>
                    <?php
                }
        }
        }
        ?>

    </div>
</div>
<?php
get_footer();
?>
