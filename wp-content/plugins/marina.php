<?php
/*
 * Plugin Name: Marina
 */
//include('shortcodes.php');
require_once ABSPATH . 'wp-admin/includes/post.php';
class MMKSruct {
    public function __construct($a) {
        $i=0;
        foreach($a as $var=>$val) {
            $varName = 'in'.$i;
            $this->$varName = $val;
            $i++;
        }
    }
}


register_activation_hook(__FILE__, 'onActivate');
function onActivate(){
    global $wpdb;
    $table_name = $wpdb->get_blog_prefix() . 'yachts';
    $charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset} COLLATE {$wpdb->collate}";
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    $sql = <<<SQL
    CREATE TABLE {$table_name} (
    id varchar(50) NOT NULL,
    yacht_name varchar(50) default "",
    model varchar(50) default "",
    year varchar(50) default "",
    length varchar(255) default "",
    cabins varchar(255) default "",
    heads varchar(255) default "",
    berths varchar(255) default "",
    deposit varchar(255) default "",
    engine varchar(255) default "",
    kind varchar(100) default "",
    price float unsigned default "0",
    country_id varchar(50),
    PRIMARY KEY  (id),
    KEY price (price)
    ) {$charset_collate};
SQL;
//  Создать таблицу.
    dbDelta( $sql );

    $table_name = $wpdb->get_blog_prefix() . 'images_for_yachts';
    $sql = <<<SQL
    CREATE TABLE {$table_name} (
    id int unsigned NOT NULL AUTO_INCREMENT,
    yacht_id varchar(50) NOT NULL,
    image varchar(255) NOT NULL default "0",
    PRIMARY KEY  (id)
    ) {$charset_collate};
SQL;
    dbDelta( $sql );

    $table_name = $wpdb->get_blog_prefix() . 'options_for_yachts';
    $sql = <<<SQL
    CREATE TABLE {$table_name} (
    id int unsigned NOT NULL Auto_increment,
    yacht_id varchar(50) NOT NULL,
    name varchar(255) NOT NULL default "0",
    PRIMARY KEY  (id)
    ) {$charset_collate};
SQL;
    dbDelta( $sql );

    $table_name = $wpdb->get_blog_prefix() . 'yachts_locations';
    $sql = <<<SQL
    CREATE TABLE {$table_name} (
    id varchar(50) NOT NULL,
    name varchar(100) NOT NULL,
    country_id varchar(50) not null,
    PRIMARY KEY  (id)
    ) {$charset_collate};
SQL;
    dbDelta( $sql );

    $table_name = $wpdb->get_blog_prefix() . 'yachts_countries';
    $sql = <<<SQL
    CREATE TABLE {$table_name} (
    id varchar(50) NOT NULL,
    name varchar(100) NOT NULL,
    shortname varchar(10) NOT NULL,
    PRIMARY KEY  (id)
    ) {$charset_collate};
SQL;
    dbDelta( $sql );

    // specify orl
    $wsdl = 'http://www.booking-manager.com/cbm_web_service2/services/CBM?wsdl';

// load client with definitions
    $soapClient = new SoapClient($wsdl, Array('trace'=>1));

    try {
        $struct = new MMKSruct(Array(3497,'office@sea-time.co.il','seatime0'));

        $result = $soapClient->getBases($struct);

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
    $table_name = $wpdb->get_blog_prefix() . 'yachts_locations';
    $tmp = $soapClient->__getLastResponse();            //получение запроса и обрезание убейте хорватов пожалуйста
    $response = html_entity_decode($tmp);
    $response = stristr($response, '<root>');
    $pos = strpos($response, '</ns1:out>');
    $response = substr($response, 0, $pos);
    $obj = new SimpleXMLElement($response);
    $locations = [];
    $counter = 0;
    global $wpdb;
    foreach ($obj as $item){
        $locations[$counter]['id'] = (string)$item->attributes()['id'];
        $locations[$counter]['name'] = (string)$item->attributes()['name'];
        $locations[$counter]['country_id'] = (string)$item->attributes()['countryid'];
        $counter++;
    }
    foreach ($locations as $location) {
        $wpdb->insert($table_name, $location);
    }


    try {
        $struct = new MMKSruct(Array(3497,'office@sea-time.co.il','seatime0'));

        $result = $soapClient->getCountries($struct);

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

    $tmp = $soapClient->__getLastResponse();            //получение запроса и обрезание убейте хорватов пожалуйста

    $response = html_entity_decode($tmp);
    $response = stristr($response, '<countries');
    $pos = strpos($response, '</ns1:out>');
    $response = substr($response, 0, $pos);
//    dd($response);
    $obj = new SimpleXMLElement($response);
//    global $wpdb;
    $table_name = $wpdb->get_blog_prefix() . 'yachts_countries';
    foreach ($obj as $country) {
        $data = [
            'id' => (string)$country->attributes()['id'],
            'name' => (string)$country->attributes()['name'],
            'shortname' => (string)$country->attributes()['shortname']
        ];

        $wpdb->insert($table_name, $data);
    }
    insertAll();
}


function onDelete() {
    global $wpdb;
    $yachts     = $wpdb->get_blog_prefix() . 'yachts';
    $countries  = $wpdb->get_blog_prefix() . 'yachts_countries';
    $locations  = $wpdb->get_blog_prefix() . 'yachts_locations';
    $options    = $wpdb->get_blog_prefix() . 'options_for_yachts';
    $images     = $wpdb->get_blog_prefix() . 'images_for_yachts';

    $sql = "DROP TABLE IF EXISTS $yachts";
    $wpdb->query($sql);
    delete_option("my_plugin_db_version");

    $sql = "DROP TABLE IF EXISTS $countries";
    $wpdb->query($sql);
    delete_option("my_plugin_db_version");

    $sql = "DROP TABLE IF EXISTS $locations";
    $wpdb->query($sql);
    delete_option("my_plugin_db_version");

    $sql = "DROP TABLE IF EXISTS $options";
    $wpdb->query($sql);
    delete_option("my_plugin_db_version");

    $sql = "DROP TABLE IF EXISTS $images";
    $wpdb->query($sql);
    delete_option("my_plugin_db_version");
}
register_deactivation_hook( __FILE__, 'onDelete' );


function getApiRequest(){
    // specify orl
    $wsdl = 'http://www.booking-manager.com/cbm_web_service2/services/CBM?wsdl';

// load client with definitions
    $soapClient = new SoapClient($wsdl, Array('trace'=>1));

    try {
        $struct = new MMKSruct(Array(3497,'office@sea-time.co.il','seatime0', 225));

        $result = $soapClient->getResources($struct);

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

    $tmp = $soapClient->__getLastResponse();            //получение запроса и обрезание убейте хорватов пожалуйста
    $response = html_entity_decode($tmp);
    $response = stristr($response, '<root>');
    $pos = strpos($response, '</ns1:out>');
    $response = substr($response, 0, $pos);
    $obj = new SimpleXMLElement($response);

    return $obj;
}
function getAllDataForYachtsFromApi(){
    $object = getApiRequest();

    $all = [];
    $simplified = [];

    $allIds = [];
    $allNames = [];
    $allPrices = [];
    $allImages = [];
    $allOptions = [];
    $allKinds = [];

    $yachtsCounter = 0;
    global $wpdb;
    $allLocations = $wpdb->get_results('select * from wp_yachts_locations');
    $allCountries = $wpdb->get_results('select * from wp_yachts_countries');
    $countriesFinal = [];
    $counterForCountries = 0;
    foreach ($object->resource as  $resource){
        $counter = 0;
        $time = strtotime($resource->prices->price[0]->attributes()['datefrom']);

        $allIds[]       = (string)$resource->attributes()['id'];
        $allNames[]     = (string)$resource->attributes()['name'];
        $allHeads[]     = (string)$resource->attributes()['heads'];
        $allYears[]     = (string)$resource->attributes()['year'];
        $allLengthes[]  = (string)$resource->attributes()['length'];
        $allCabins[]    = (string)$resource->attributes()['cabins'];
        $allDeposits[]  = (string)$resource->attributes()['deposit'];
        $allEngines[]   = (string)$resource->attributes()['engine'];
        $allModels[]    = (string)$resource->attributes()['model'];
        $allBerths[]    = (string)$resource->attributes()['berths'];
        $allKinds[]     = (string)$resource->attributes()['kind'];


        foreach ($allLocations as $location) {
            if ($location->id == (string)$resource->locations->attributes()['defaultbaseid'] ){
                foreach ($allCountries as $country) {
                    if ($location->country_id == $country->id){
                        $countriesFinal[$counterForCountries] = $country->name;
                        $counterForCountries++;
                    }

                }
            }
        }
        $allPorts[]     = (string)$resource->locations->attributes()['defaultbaseid'];

        foreach ($resource->prices as $price){
            foreach ($price as $key => $item) {
                if ($time < strtotime($item->attributes()['datefrom'])){
                    $time = strtotime($item->attributes()['datefrom']);
                    $innerPrice = (string)$item->attributes()['price'];
                }
                $counter++;
            }
            if ($price->count() == $counter){
                $allPrices[] = $innerPrice;
            }
        }
        foreach ($resource->images as $image){
            foreach ($image as $i){
                $allImages[$yachtsCounter][] = (string)$i->attributes()['href'];
            }
        }
        foreach ($resource->equipment as $equipmentItem){
            foreach ($equipmentItem as $i){
                $allOptions[$yachtsCounter][] = (string)$i->attributes()['name'];
            }
        }
        $all['names'][$allIds[$yachtsCounter]] = $allNames[$yachtsCounter];
        $all['images'][$allIds[$yachtsCounter]] = $allImages[$yachtsCounter];
        $all['prices'][$allIds[$yachtsCounter]] = $allPrices[$yachtsCounter];
        $all['models'][$allIds[$yachtsCounter]] = $allModels[$yachtsCounter];
        $all['heads'][$allIds[$yachtsCounter]] = $allHeads[$yachtsCounter];
        $all['years'][$allIds[$yachtsCounter]] = $allYears[$yachtsCounter];
        $all['length'][$allIds[$yachtsCounter]] = $allLengthes[$yachtsCounter];
        $all['cabins'][$allIds[$yachtsCounter]] = $allCabins[$yachtsCounter];
        $all['engines'][$allIds[$yachtsCounter]] = $allEngines[$yachtsCounter];
        $all['deposits'][$allIds[$yachtsCounter]] = $allDeposits[$yachtsCounter];
        $all['berths'][$allIds[$yachtsCounter]] = $allBerths[$yachtsCounter];
        $all['kinds'][$allIds[$yachtsCounter]] = $allKinds[$yachtsCounter];
        $all['countries'][$allIds[$yachtsCounter]] = $countriesFinal[$yachtsCounter];
        $all['options'][$allIds[$yachtsCounter]] = $allOptions[$yachtsCounter];
        $yachtsCounter++;


    }
    return $all;
}
function insertAll(){

    $yachts = getAllDataForYachtsFromApi();
    $counter = 1;
    global $wpdb;
    $yachtsId = [];
    $table_name = $wpdb->get_blog_prefix() . 'yachts';
    $wpdb->query("delete from $table_name");
    $allLocations = $wpdb->get_results('select * from wp_yachts_locations');

    $allCountries = $wpdb->get_results('select * from wp_yachts_countries');
    $countriesFinal = [];

    foreach ($allLocations as $location){
        foreach ($allCountries as $country) {
            if ($location->country_id == $country->id){
                $countriesFinal[]['id'] = $country->id;
                $countriesFinal[]['name'] = $country->name;
            }
        }
    }


    foreach ($yachts['names'] as $id => $name) {
        $data = [
            'id' => (string)$id,
            'yacht_name' => $name
        ];
        if ($wpdb->get_var("select id from $table_name where id = $id")){
            $wpdb->delete($table_name, array('id' => $id));
        }
        $wpdb->insert($table_name, $data);
        $yachtsId[] = $counter;
        $counter++;
    }
    foreach ($yachts['prices'] as $id => $price) {

        $data = [
            'price' => $price
        ];
        $where = [
            'id' => $id
        ];
        $wpdb->update($table_name, $data, $where);

        // Создаем массив данных новой записи
        $title = 'yacht-'.$id;
        if (post_exists($title)){
            wp_delete_post(post_exists($title), true);
        }
        $post_data = array(
            'post_title'    => 'yacht-'.$id,
            'post_content'  => "[yacht id='".$id."']",
            'post_status'   => 'publish',
            'post_author'   => 1,
            'post_category' => array( 1 ),
            'post_type'     => 'yacht'
        );

// Вставляем запись в базу данных
        wp_insert_post( $post_data );
    }
    foreach ($yachts['models'] as $id => $model) {
        $data = [
            'model' => $model
        ];
        $where = [
            'id' => $id
        ];
        $wpdb->update($table_name, $data, $where);
    }
    foreach ($yachts['heads'] as $id => $head) {
        $data = [
            'heads' => $head
        ];
        $where = [
            'id' => $id
        ];
        $wpdb->update($table_name, $data, $where);
    }
    foreach ($yachts['years'] as $id => $year) {
        $data = [
            'year' => $year
        ];
        $where = [
            'id' => $id
        ];
        $wpdb->update($table_name, $data, $where);
    }
    foreach ($yachts['length'] as $id => $length) {
        $data = [
            'length' => $length
        ];
        $where = [
            'id' => $id
        ];
        $wpdb->update($table_name, $data, $where);
    }
    foreach ($yachts['cabins'] as $id => $cabin) {
        $data = [
            'cabins' => $cabin
        ];
        $where = [
            'id' => $id
        ];
        $wpdb->update($table_name, $data, $where);
    }
    foreach ($yachts['engines'] as $id => $engine) {
        $data = [
            'engine' => $engine
        ];
        $where = [
            'id' => $id
        ];
        $wpdb->update($table_name, $data, $where);
    }
    foreach ($yachts['deposits'] as $id => $deposit) {
        $data = [
            'deposit' => $deposit
        ];
        $where = [
            'id' => $id
        ];
        $wpdb->update($table_name, $data, $where);
    }
    foreach ($yachts['berths'] as $id => $berth) {
        $data = [
            'berths' => $berth
        ];
        $where = [
            'id' => $id
        ];
        $wpdb->update($table_name, $data, $where);
    }
    foreach ($yachts['kinds'] as $id => $kind) {
        $data = [
            'kind' => $kind
        ];
        $where = [
            'id' => $id
        ];
        $wpdb->update($table_name, $data, $where);
    }
    foreach ($yachts['countries'] as $id => $country) {
//        foreach ($allLocations as $location) {
//            if ($location->id == $country){
//                $name = $location->name;
//            }
//        }
        $data = [
            'country_id' => $country
        ];
        $where = [
            'id' => $id
        ];
        $wpdb->update($table_name, $data, $where);

    }

    $table_name = $wpdb->get_blog_prefix() . 'images_for_yachts';
    $innerCounter = 0;
    $wpdb->query("delete from $table_name");
    foreach ($yachts['images'] as $id => $array) {

        if (isset($array)){

            if (count($array) > 1){
                $yachtsId[] = $counter;
                for ($i = 0; $i < count($array); $i++){
                    $counter++;
                    $yachtsId[] = $counter;
                }
            }
            foreach ($array as $image) {
                $data = [
                    'id' => $yachtsId[$innerCounter],
                    'yacht_id' => (string)$id,
                    'image' => $image
                ];
                $yachtId = $yachtsId[$innerCounter];
                if ($wpdb->get_var("select id from $table_name where id = $yachtId")){
                    $wpdb->delete($table_name, array('id' => $yachtId));
                }
                $innerCounter++;
                $wpdb->insert($table_name, $data);
            }
        }
    }

    $table_name = $wpdb->get_blog_prefix() . 'options_for_yachts';
    $innerCounter = 0;
    $wpdb->query("delete from $table_name");
    foreach ($yachts['options'] as $id => $array) {

        if (isset($array)){

            if (count($array) > 1){
                $yachtsId[] = $counter;
                for ($i = 0; $i < count($array); $i++){
                    $counter++;
                    $yachtsId[] = $counter;
                }
            }
            foreach ($array as $option) {
                $data = [
                    'id' => $yachtsId[$innerCounter],
                    'yacht_id' => (string)$id,
                    'name' => $option
                ];
                $yachtId = $yachtsId[$innerCounter];
                if ($wpdb->get_var("select id from $table_name where id = $yachtId")){
                    $wpdb->delete($table_name, array('id' => $yachtId));
                }
                $innerCounter++;
                $wpdb->insert($table_name, $data);
            }
        }
    }

}
function getAllDataFromDb(){
    global $wpdb;
    $table_name = $wpdb->get_blog_prefix() . 'yachts';
    $ids = $wpdb->get_col("select id from $table_name");
    foreach ($ids as $count => $id){
        $row = $wpdb->get_row("select * from $table_name where id = $id");
        echo ++$count.': <br>';
        echo $row->price.' '.$row->model.' '.$row->price.' '.$row->length.'<hr>';
    }
}


function test(){
    // specify orl
    $wsdl = 'http://www.booking-manager.com/cbm_web_service2/services/CBM?wsdl';

// load client with definitions
    $soapClient = new SoapClient($wsdl, Array('trace'=>1));

    try {
        $struct = new MMKSruct(Array(3497,'office@sea-time.co.il','seatime0'));

        $result = $soapClient->getCountries($struct);

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

    $tmp = $soapClient->__getLastResponse();            //получение запроса и обрезание убейте хорватов пожалуйста

    $response = html_entity_decode($tmp);
    $response = stristr($response, '<countries');
    $pos = strpos($response, '</ns1:out>');
    $response = substr($response, 0, $pos);
//    dd($response);
    $obj = new SimpleXMLElement($response);
    global $wpdb;
    $table_name = $wpdb->get_blog_prefix() . 'yachts_countries';
//    dd($obj);
    foreach ($obj as $country) {
        $data = [
            'id' => (string)$country->attributes()['id'],
            'name' => (string)$country->attributes()['name'],
            'shortname' => (string)$country->attributes()['shortname']
        ];

        $wpdb->insert($table_name, $data);
    }

}


function singleYacht($atts){
    $abc = shortcode_atts([
        'id' => 1
    ], $atts);
    $id = $abc['id'];
    global $wpdb;
    $yacht = $wpdb->get_results("select * from wp_yachts where id = $id");
    $img = $wpdb->get_results("select * from wp_images_for_yachts where yacht_id = $id");

//    dd($yacht);
    ?>
    <style>
        .yachts-wrapper{
            direction: ltr;
            margin: 0 5% 3% 5%;
            width: 90%;
            height: 100%;

        }
        .main-info{
            display: flex;
            flex-direction: row;
            width: 100%;
            height: 100%;
        }
        .main-info .photos{
            /*background-color: #ff2c1d;*/
            min-width: 500px;
            min-height: 500px;
            margin-right: 20px;
        }
        .all-info{
            position: relative;
        }
        .all-info h2{
            margin-top: auto;
            text-transform: uppercase;
            color: #1D9FB3;
        }
        .all-info .description{
            font-weight: 100;
            text-align: justify;
            font-size: 14px;
            line-height: 2em;
        }
        .all-info .price{
            position: absolute;
            bottom: 0;
        }
        .all-info .price p{
            margin: 0;
        }
        .all-info .price span{
            margin-left: 12px;
            font-size: 32px;
            color: #1D9FB3;
        }
        .all-info button{
            width: 150px;
            /*padding: 2px 12px;*/
            background-color: white;
            margin-top: 40px;
            border: solid #d5d6db 2px;
            border-radius: 20PX;
            margin-bottom: 30px;
        }
        .options{
            position: relative;
            display: flex;
            flex-direction: column;
            flex-wrap: wrap;
            padding:20px 40px 20px 40px;
            min-height: 320px;
            max-height: 320px;
            margin-top: 50px;
            background-color: #1D9FB3;
            -webkit-box-shadow: 0px 0px 61px -9px rgba(29,159,179,1);
            -moz-box-shadow: 0px 0px 61px -9px rgba(29,159,179,1);
            box-shadow: 0px 0px 61px -9px rgba(29,159,179,1);
        }
        .options .opt{
            width: 40%;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            border-top: solid #51b5c5 1px;
        }
        /*.options .opt:nth-child(6){*/
        /*margin-top: 73px;*/
        /*width: 40%;*/
        /*display: flex;*/
        /*flex-direction: row;*/
        /*justify-content: space-between;*/
        /*border-top: solid #51b5c5 1px;*/
        /*}*/
        .options .opt span:first-child{
            color: white;
            font-weight: 400;
            margin: 5px;
            font-size: 16px;
            padding-top: 3px;
        }
        .options .opt span:last-child{
            margin: 5px;
            opacity: 0.5;
            color: white;
            font-size: 18px;
            padding-top: 2px;
            font-weight: 200;
        }
        .options .spacer-left h2{
            text-transform: capitalize;
            color: white;
            font-size: 34px;
            margin: 0;
        }
        .options .other{
            position: absolute;
            bottom: 34px;
            left: 50.5%;
        }
        .options .other a{
            color: #a7d3dc;
            text-decoration: underline;
        }
        .options .other a:visited{
            color: #a7d3dc;
            text-decoration: underline;
        }
        .line{
            margin-bottom: 20px;
            height: 2px;
            width: 30px;
            background-color: white;
        }
        .spacer-left{
            width: 50%;
        }
        .spacer-right{
            width: 50%;
        }
        .spacer-right h2{
            opacity: 0;
        }
    </style>

    <div class="yachts-wrapper">
        <h1>
            yacht page
        </h1>
        <div class="line"></div>
        <div class="main-info">
            <div class="photos">
                <img src="<?= $img[0]->image ?>" alt="">
            </div>
            <div class="all-info">
                <h2>
                    <?= $yacht[0]->yacht_name?>
                </h2>
                <div class="description">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab cum eius ipsum perferendis unde.
                    Aliquid blanditiis deserunt dolorum impedit laudantium neque quam vero voluptate.
                    Commodi debitis dicta esse expedita minima nesciunt obcaecati, placeat, praesentium
                    provident velit voluptatem voluptates! A amet architecto aspernatur at atque blanditiis
                    consequatur ducimus ea eaque earum, eligendi esse et excepturi facere fugit inventore ipsa labore
                    laborum maxime minus nostrum odio officia porro quas qui quia quis quod ratione repudiandae sunt
                    ut vel veritatis voluptas. Aspernatur at aut consequatur dignissimos, et explicabo fugiat incidunt
                    natus quibusdam quidem, quo repellat sint. Cum delectus est incidunt minus tempora temporibus unde
                    vero? Ab aspernatur cupiditate earum, eum, exercitationem fuga magni necessitatibus
                    numquam odio officia, quidem sunt voluptates. A autem consequatur cumque dignissimos
                    dolor, ipsam iure numquam? A architecto ducimus error quo. Autem consequatur corporis ea neque quidem sint tempore!
                    A assumenda at aut commodi id ipsa laudantium praesentium quas velit?
                </div>
<!--                <button>-->
<!--                    download file-->
<!--                </button>-->


                <div class='price'>
                    <p>
                        Price: <span> <?= $yacht[0]->price?> €</span>
                    </p>
                </div>

            </div>
        </div>

        <div class="options">
            <div class="spacer-left">
                <h2>Options</h2>
            </div>

            <div class="line"></div>
            <div class="opt">
                <span>Model</span> <span><?=$yacht[0]->model ?></span>
            </div>
            <div class="opt">
                <span>Kind</span> <span> <?= $yacht[0]->kind?></span>
            </div>
            <div class="opt">
                <span>Length</span> <span> <?= $yacht[0]->length?> m</span>
            </div>
            <div class="opt">
                <span>Heads</span> <span> <?= $yacht[0]->heads?></span>
            </div>
            <div class="opt">
                <span>Berths</span> <span> <?= $yacht[0]->berths?></span>
            </div>


            <div class="spacer-right">
                <h2>Options</h2>
            </div>
            <div class="opt">
                <span>Engine</span> <span> <?= $yacht[0]->engine?></span>
            </div>
            <div class="opt">
                <span>Cabins</span> <span> <?= $yacht[0]->cabins?></span>
            </div>
            <div class="other">
                <a href="#">other models</a>
            </div>

        </div>
    </div>
    <?php
}
add_shortcode('yacht', 'singleYacht');