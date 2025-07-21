<?php

use App\Data;
use App\Dir;
use App\Entity\Extensions\Md;
use App\Entity\Profession;
use App\Entity\Release;
use App\Entity\Section;
use App\Template;
use App\Writer;
use Symfony\Component\Yaml\Yaml;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require __DIR__ . '/vendor/autoload.php';

$data = new Data();
$loader = new FilesystemLoader(__DIR__ . '/templates');
$twig = new Environment($loader);


$file = $data->get('release-1.yml');

$content = $data->read($file);
$parseData = Yaml::parse($content);

$sections = new ArrayObject(
    array_map(
        function ($section) {
           return new Section(
               $section['name'],
               $section['description'],
               $section['section_id'],
               new ArrayObject(
                    array_map(function ($profession) {
                       return new Profession(
                           $profession['name'],
                           $profession['slug'],
                           $profession['ranks']
                       );
                   }, $section['professions'])
               )
           );
        }, $parseData[0]['sections']
    )
);

$release = new Release(
    $parseData[0]['release_id'],
    $parseData[0]['title'],
    $parseData[0]['description'],
    $sections
);


$template = new Template($loader,[
    'release' => 'release.md.twig',
    'section' => 'section.md.twig',
    'profession' => 'profession.md.twig',
]);
$writer = new Writer($release, $twig, $template, new Dir(), new Md());




$writer->render();

die;






