<?php

namespace App;

use App\Entity\Profession;
use App\Entity\Release;
use App\Entity\Section;
use App\Interface\Extension;
use App\Interface\IWriter;
use Twig\Environment;

class Writer implements IWriter
{
    private Environment $twig;
    private Template $template;
    private Dir $dir;
    private Release $release;
    private Extension $extension;
    public function __construct(Release $release, Environment $twig, Template $template, Dir $dir, Extension $extension)
    {
        $this->release = $release;
        $this->twig = $twig;
        $this->template = $template;
        $this->dir = $dir;
        $this->extension = $extension;
    }

    public function render(): void
    {
        $this->dir->makeDir();
        $releasePath = $this->renderRelease();
        foreach ($this->release->getSections() as $section) {
            $sectionPath = $this->renderSections($releasePath, $section);
            foreach ($section->professions as $profession) {
                $this->renderProfessions($sectionPath, $profession, $section);
            }
        }
    }

    private function renderRelease(): string
    {
        $releasePath = $this->dir->makeDir($this->release->release_id);
        $filename = $this->getFullFilename($releasePath, 'index');
        $markdown = $this->twig->render($this->template->get('release'), ['release' => $this->release]);
        $this->writeFile($filename, $markdown);
        return $releasePath;
    }
    private function renderSections(string $releasePath, Section $section): string
    {
        $sectionPath = $this->dir->makeDir($section->section_id, $releasePath);
        $filename = $this->getFullFilename($sectionPath, 'index');

        $markdown = $this->twig->render($this->template->get('section'), [
            'section' => $section,
            'release' => $this->release
        ]);
        $this->writeFile($filename, $markdown);

        return $sectionPath;
    }
    public function renderProfessions(string $sectionPath, Profession $profession, Section $section): void
    {
        $professionPath = $this->dir->makeDir($profession->slug, $sectionPath);
        $filename = $this->getFullFilename($professionPath, 'index');
        $markdown = $this->twig->render($this->template->get('profession'), [
            'profession' => $profession,
            'section' => $section,
            'release' => $this->release
        ]);
        $this->writeFile($filename, $markdown);
    }
    private function getFullFilename(string $sectionPath, string $slug): string
    {
        return $sectionPath. '/'. $slug . $this->extension->get();
    }
    public function writeFile(string $filename, string $markdown): void
    {
        $result = file_put_contents($filename, $markdown);
        if($result === false){
            throw new \DomainException("Cannot write file '$filename'.");
        }
    }

}