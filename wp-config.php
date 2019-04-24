<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define( 'DB_NAME', 'maria' );

/** Имя пользователя MySQL */
define( 'DB_USER', 'root' );

/** Пароль к базе данных MySQL */
define( 'DB_PASSWORD', '' );

/** Имя сервера MySQL */
define( 'DB_HOST', 'localhost' );

/** Кодировка базы данных для создания таблиц. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Схема сопоставления. Не меняйте, если не уверены. */
define( 'DB_COLLATE', '' );

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'F;X{)`$9=FSArU%-6<-tnVL x{*D(R|QAB=I4s|!.i_H,kmy/M3<w@M.kxuj&F/4' );
define( 'SECURE_AUTH_KEY',  'b5/|LLwo71e)=+_E`Q3Vu|`ZnuKL`YrW,~F]e_cvws13x]^%)q~TuItT.8+K|S1-' );
define( 'LOGGED_IN_KEY',    ',D3# hI6:bq#n4q{?DKs3_&]pxc:wuYQ+[c<`oZ49IZ5`7t)|tKpA~!Hu),>}jrS' );
define( 'NONCE_KEY',        '1=H8et++xUThgg5esfFYEa#bOzV=gs}5:uW^W?PV]~P-GNSzwf#yggPg,zsq/Lj3' );
define( 'AUTH_SALT',        '?Qc@9ry|R0GnyjmLZM09-+1FSK>LnG[~NuTeKW8Z*g?W~;zQaUPVHe/bJK@5Fq+B' );
define( 'SECURE_AUTH_SALT', '$C0dlNgbkahJX9AInW$v}hvyv!d7}<-(SZ}sY0Y}TPbgU,8MW%b%IwY}zIAkr}SM' );
define( 'LOGGED_IN_SALT',   'j~@zYb*HOk2m<,|dMGf[~YJ*<hYSCd?Nyx|v/gzn1CeRU%GJs49Nc>yk|eXCDm-l' );
define( 'NONCE_SALT',       '(a._a{q Fz8&7=betRhA4<xztBPF&J&/ZL!yB);GYqa$Uvs/3)N7OX*5o^VgI)s:' );

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в Кодексе.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Инициализирует переменные WordPress и подключает файлы. */
require_once( ABSPATH . 'wp-settings.php' );
