<?php
/*
Template Name: single-yacht
*/

get_header();
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
    <?php
global $post;
setup_postdata( $post );
echo the_content()?>
<!--    <div class="yachts-wrapper">-->
<!--        <h1>-->
<!--            yacht page-->
<!--        </h1>-->
<!--        <div class="line"></div>-->
<!--        <div class="main-info">-->
<!--            <div class="photos">-->
<!---->
<!--            </div>-->
<!--            <div class="all-info">-->
<!--                <h2>-->
<!--                    Lorem ipsum.-->
<!--                </h2>-->
<!--                <div class="description">-->
<!--                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab cum eius ipsum perferendis unde.-->
<!--                    Aliquid blanditiis deserunt dolorum impedit laudantium neque quam vero voluptate.-->
<!--                    Commodi debitis dicta esse expedita minima nesciunt obcaecati, placeat, praesentium-->
<!--                    provident velit voluptatem voluptates! A amet architecto aspernatur at atque blanditiis-->
<!--                    consequatur ducimus ea eaque earum, eligendi esse et excepturi facere fugit inventore ipsa labore-->
<!--                    laborum maxime minus nostrum odio officia porro quas qui quia quis quod ratione repudiandae sunt-->
<!--                    ut vel veritatis voluptas. Aspernatur at aut consequatur dignissimos, et explicabo fugiat incidunt-->
<!--                    natus quibusdam quidem, quo repellat sint. Cum delectus est incidunt minus tempora temporibus unde-->
<!--                    vero? Ab aspernatur cupiditate earum, eum, exercitationem fuga magni necessitatibus-->
<!--                    numquam odio officia, quidem sunt voluptates. A autem consequatur cumque dignissimos-->
<!--                    dolor, ipsam iure numquam? A architecto ducimus error quo. Autem consequatur corporis ea neque quidem sint tempore!-->
<!--                    A assumenda at aut commodi id ipsa laudantium praesentium quas velit?-->
<!--                </div>-->
<!--                <button>-->
<!--                    download file-->
<!--                </button>-->
<!---->
<!---->
<!--                <div class='price'>-->
<!--                    <p>-->
<!--                        Price: <span>79 500 €</span>-->
<!--                    </p>-->
<!--                </div>-->
<!---->
<!--            </div>-->
<!--        </div>-->
<!---->
<!--        <div class="options">-->
<!--            <div class="spacer-left">-->
<!--                <h2>Options</h2>-->
<!--            </div>-->
<!---->
<!--            <div class="line"></div>-->
<!--            <div class="opt">-->
<!--                <span>LOA</span> <span>2</span>-->
<!--            </div>-->
<!--            <div class="opt">-->
<!--                <span>Beam</span> <span>2</span>-->
<!--            </div>-->
<!--            <div class="opt">-->
<!--                <span>Project</span> <span>2</span>-->
<!--            </div>-->
<!--            <div class="opt">-->
<!--                <span>Light Offset</span> <span>2</span>-->
<!--            </div>-->
<!--            <div class="opt">-->
<!--                <span>Max engine power</span> <span>2</span>-->
<!--            </div>-->
<!--            <div class="spacer-right">-->
<!--                <h2>Options</h2>-->
<!--            </div>-->
<!--            <div class="opt">-->
<!--                <span>Fuel Tank</span> <span>2</span>-->
<!--            </div>-->
<!--            <div class="opt">-->
<!--                <span>Fresh water</span> <span>2</span>-->
<!--            </div>-->
<!--            <div class="other">-->
<!--                <a href="#">other models</a>-->
<!--            </div>-->
<!---->
<!--        </div>-->
<!--    </div>-->


<?php
get_footer();
