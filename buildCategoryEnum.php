<?php

use Illuminate\Support\Str;

require __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$jsFileContent = file_get_contents(
    __DIR__
    . DIRECTORY_SEPARATOR
    . 'node_modules'
    . DIRECTORY_SEPARATOR
    . '@pierreminiggio'
    . DIRECTORY_SEPARATOR
    . 'heropost-youtube-posting'
    . DIRECTORY_SEPARATOR
    . 'index.js'
);

$splitOnEnumStart = explode('const videoCategories = {', $jsFileContent, 2)[1];
$rawEnumContent = explode('}', $splitOnEnumStart, 2)[0];
$rawEnumLines = explode(',', $rawEnumContent);

$enumValues = [];

foreach ($rawEnumLines as $rawEnumLine) {
    $explodedEnumLine = explode(':', $rawEnumLine);
    $enumKey = Str::upper(
        Str::slug(
            str_replace(
                '&',
                'and',
                substr(
                    trim($explodedEnumLine[0]),
                    1,
                    -1
                )
            ),
            '_'
        )
    );
    $enumValue = (int) trim($explodedEnumLine[1]);
    $enumValues[$enumKey] = $enumValue;
}

$enumContent = '';

foreach ($enumValues as $enumKey => $enumValue) {
    $enumContent .=
        PHP_EOL
        . '    '
        . 'public const '
        . $enumKey
        . ' = '
        . $enumValue
        . ';'
    ;
}

$className = 'YoutubeCategoriesEnum';

$classContent = <<<PHP
<?php

namespace PierreMiniggio\HeropostYoutubePosting;

class $className
{
    $enumContent
}
PHP;

file_put_contents(
    __DIR__ . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . $className . '.php',
    $classContent
);
