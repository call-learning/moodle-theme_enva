<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.
namespace theme_enva;

use context_course;
use context_system;
use moodle_page;

/**
 * Class setup
 *
 * Utility setup class.
 *
 * @copyright   2020 Laurent David - CALL Learning <laurent@call-learning.fr>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class setup {
    // @codingStandardsIgnoreStart
    // phpcs:disable
    /**
     * Homepage block definition
     */
    const HOMEPAGE_BLOCK_DEFINITION = [
        [
            'blockname' => 'online_users',
            'showinsubcontexts' => '0',
            'defaultregion' => 'content',
            'defaultweight' => '1',
            'configdata' => [],
            'capabilities' => [],
            'files' => []
        ],
        [
            'blockname' => 'html',
            'showinsubcontexts' => '0',
            'defaultregion' => 'content',
            'defaultweight' => '1',
            'configdata' =>
                [
                    "title" => "Découvrez notre large éventail de cours en ligne spécialisés en médecine vétérinaire",
                    "format" => "1",
                    "classes" => "",
                    "text" => '
                    <p>Nos cours couvrent tous les aspects de la médecine vétérinaire, des soins aux petits animaux à la gestion des élevages. Chaque cours est conçu par des experts du domaine et comprend des vidéos, des lectures et des quiz interactifs pour vous assurer une compréhension complète et approfondie.</p>'],
            'capabilities' => [],
            'files' => []
        ],
        [
            'blockname' => 'html',
            'showinsubcontexts' => '0',
            'defaultregion' => 'content',
            'defaultweight' => '1',
            'configdata' =>
                [
                    "title" => "Accédez à des ressources pédagogiques de pointe",
                    "format" => "1",
                    "classes" => "",
                    "text" => '
                    <p>En vous inscrivant à nos cours, vous bénéficiez d\'un accès illimité à des ressources pédagogiques de haute qualité, incluant des articles scientifiques, des études de cas, et des forums de discussion avec des professionnels expérimentés. Nos syllabus détaillés vous guident tout au long de votre parcours d\'apprentissage, en précisant les objectifs de chaque module et les compétences à acquérir.</p>'],
            'capabilities' => [],
            'files' => []
        ],
        [
            'blockname' => 'html',
            'showinsubcontexts' => '0',
            'defaultregion' => 'content',
            'defaultweight' => '2',
            'configdata' =>
                [
                    "title" => "EVE : Etudes et vie étudiante à l'EnvA",
                    "format" => "1",
                    "classes" => "block-full-width",
                    "text" => '
                    <h1 class="h2">EVE : Etudes et vie étudiante à l\'EnvA</h1>
<div class="container-fluid">
    <div class="row iconboxes">
        <div class="iconbox col-6 col-md-3">
            <div class="inner">
                <div class="iconcircle"><span class="fa fa-map-o" aria-hidden="true"></span></div>
                <div class="iconbox-content">
                    <h4>Syllabus</h4>
                    <a href="/local/envasyllabus/index.php" target="_blank" rel="noopener"><span class="sr-only">Accéder</span></a>
                    <p>Accès au catalogue des UC (syllabus)</p>
                </div>
            </div>
        </div>
        <div class="iconbox col-6 col-md-3">
            <div class="inner">
                <div class="iconcircle"><span class="far fa-calendar-alt"></span></div>
                <div class="iconbox-content">
                    <h4>Planning</h4>
                    <a href="https://hyperplanning.vet-alfort.fr/new" target="_blank" rel="noopener"><span class="sr-only">Accéder</span></a>
                    <p>Accès à l\'application Hyperplanning</p>
                </div>
            </div>
        </div>
        <div class="iconbox col-6 col-md-3">
            <div class="inner">
                <div class="iconcircle"><span class="fa fa-comments"></span></div>
                <div class="iconbox-content">
                    <h4>StageVet</h4>
                    <a href="https://www.stagevet.fr" target="_blank" rel="noopener"><span class="sr-only">Accéder</span></a>
                    <p>Accès à StageVet</p>
                </div>
            </div>
        </div>
        <div class="iconbox col-6 col-md-3">
            <div class="inner">
                <div class="iconcircle"><span class="fas fa-cloud-upload-alt"></span></div>
                <div class="iconbox-content">
                    <h4>Office</h4>
                    <a href="https://outlook.office365.com/" target="_blank" rel="noopener"><span class="sr-only">Accéder</span></a>
                    <p>Accès à Office 365</p>
                </div>
            </div>
        </div>
        <div class="iconbox col-6 col-md-3">
            <div class="inner">
                <div class="iconcircle"><span class="fas fa-book"></span></div>
                <div class="iconbox-content">
                    <h4>E-book</h4>
                    <a href="http://bibliotheque.vet-alfort.fr/ListRecord.htm?list=folder&amp;folder=38" target="_blank" rel="noopener"><span class="sr-only">Accéder</span></a>
                    <p>Accès à la bibliothèque de livres dématérialisés</p>
                </div>
            </div>
        </div>
        <div class="iconbox col-6 col-md-3">
            <div class="inner">
                <div class="iconcircle"><span class="fas fa-laptop"></span></div>
                <div class="iconbox-content">
                    <h4>Revues</h4>
                    <a href="http://revues.vet-alfort.fr/" target="_blank" rel="noopener"><span class="sr-only">Accéder</span></a>
                    <p>Accès aux périodiques en ligne</p>
                </div>
            </div>
        </div>
        <div class="iconbox col-6 col-md-3">
            <div>
                <div class="iconcircle"><span class="fas fa-graduation-cap"></span></div>
                <div class="iconbox-content">
                    <h4>Enseignants</h4>
                    <a href="https://eve.vet-alfort.fr/course/view.php?id=463"><span class="sr-only">Accéder</span></a>
                    <p>Accès à l\'espace partagé pour les enseignants</p>
                </div>
            </div>
        </div>
    </div>
</div>'],
            'capabilities' => [],
            'files' => []
        ],
        [
            'blockname' => 'html',
            'showinsubcontexts' => '0',
            'defaultregion' => 'content',
            'defaultweight' => '3',
            'configdata' =>
                [
                    "title" => "Les pages d'information pour les promotions",
                    "format" => "1",
                    "classes" => "block-full-width",
                    "text" => '<div class="container-fluid">
    <div class="row blockboxes">
        <div class="blockbox col-6 col-md-3">
            <div class="blocknumber_box">
                <div class="blocknumber_icon">1</div>
                <div class="blocknumber_content">
                    <h4>Première année</h4>
                    <p><span class="readmore"><a href="https://eve.vet-alfort.fr/course/view.php?id=836" target="_blank" rel="noopener">Ouvrir</a></span></p>
                    <p></p>
                </div>
            </div>
        </div>
        <div class="blockbox col-6 col-md-3">
            <div class="blocknumber_box">
                <div class="blocknumber_icon">2</div>
                <div class="blocknumber_content">
                    <h4>Deuxième année</h4>
                    <p><span class="readmore"><a title="https://eve.vet-alfort.fr/course/view.php?id=804" href="https://eve.vet-alfort.fr/course/view.php?id=804">Ouvrir</a></span></p>
                    <p></p>
                </div>
            </div>
        </div>
        <div class="blockbox col-6 col-md-3">
            <div class="blocknumber_box">
                <div class="blocknumber_icon">3</div>
                <div class="blocknumber_content">
                    <h4>Troisième année</h4>
                    <p><span class="readmore"><a title="https://eve.vet-alfort.fr/course/view.php?id=793" href="https://eve.vet-alfort.fr/course/view.php?id=793">Ouvrir</a></span></p>
                </div>
            </div>
        </div>
        <div class="blockbox col-6 col-md-3">
            <div class="blocknumber_box">
                <div class="blocknumber_icon">4</div>
                <div class="blocknumber_content">
                    <h4>Quatrième année</h4>
                    <p><span class="readmore"><a title="https://eve.vet-alfort.fr/course/view.php?id=792" href="https://eve.vet-alfort.fr/course/view.php?id=792">Ouvrir</a></span></p>
                </div>
            </div>
        </div>
        <div class="blockbox col-6 col-md-3">
            <div class="blocknumber_box">
                <div class="blocknumber_icon">5</div>
                <div class="blocknumber_content">
                    <h4>Cinquième année</h4>
                    <p><span class="readmore"><a href="https://eve.vet-alfort.fr/course/view.php?id=742" target="_blank" rel="noopener">Ouvrir</a></span></p>
                </div>
            </div>
        </div>
        <div class="blockbox col-6 col-md-3">
            <div class="blocknumber_box">
                <div class="blocknumber_icon">6</div>
                <div class="blocknumber_content">
                    <h4>Sixième année</h4>
                    <p><span class="readmore"><a title="https://eve.vet-alfort.fr/course/view.php?id=694" href="https://eve.vet-alfort.fr/course/view.php?id=694">Ouvrir</a></span></p>
                </div>
            </div>
        </div>
        <div class="blockbox col-6 col-md-3">
            <div class="blocknumber_box">
                <div class="blocknumber_icon">&nbsp;</div>
                <div class="blocknumber_content">
                    <h4>Toutes promos</h4>
                    <p><span class="readmore"><a href="http://eve.vet-alfort.fr/course/view.php?id=214">Ouvrir</a> </span></p>
                </div>
            </div>
        </div>
    </div>
</div>'],
            'capabilities' => []
        ],

    ];

    const CAROUSEL_DATA = [
        [
            'title' => 'Exploration des Pathologies Exotiques',
            'text' => 'Plongez dans l\'univers fascinant des pathologies exotiques. Apprenez à diagnostiquer et traiter des maladies rares rencontrées chez les animaux exotiques. Découvrez notre nouveau module spécialisé et enrichissez vos compétences cliniques.',
            'imagepath' => 'data/carousel/slide1.jpg',
            'link' => 'https://www.vet-alfort.fr',
        ],
        [
            'title' => 'Guide de la Chirurgie Vétérinaire',
            'text' => 'Ce guide est indispensable pour tous ceux qui souhaitent exceller en chirurgie vétérinaire. Comprenez les techniques avancées et les protocoles chirurgicaux essentiels. Téléchargez le guide et devenez un expert en chirurgie animale.',
            'imagepath' => 'data/carousel/slide2.jpg',
            'link' => 'https://www.vet-alfort.fr',
        ],
        [
            'title' => 'Opportunités de Recherche en Médecine Vétérinaire',
            'text' => 'La recherche est au cœur de l\'innovation en médecine vétérinaire. Participez à nos programmes de recherche et contribuez à des découvertes révolutionnaires. Explorez les opportunités et rejoignez notre équipe de chercheurs passionnés.',
            'imagepath' => 'data/carousel/slide3.jpg',
            'link' => 'https://www.vet-alfort.fr',
        ],
    ];

    // @codingStandardsIgnoreEnd
    // phpcs:enable
    /**
     * The defaults settings
     */
    const DEFAULT_SETTINGS = [
        'theme_enva' => [
            'defaulthomepage' => HOMEPAGE_MY,
        ],
        'moodle' => [
            'block_html_allowcssclasses' => 1,
        ]
    ];

    /**
     * Install updates
     */
    public static function install_update() {
        global $PAGE, $CFG, $DB, $OUTPUT;

        static::setup_config_values();
        // Note here: this will only define capabilities for the default page. If we
        // want the dashboard to work as expected we also need to set forcedefaultmymoodle to true.
        // Setup Home page.
        $oldpage = $PAGE;
        $page = new moodle_page();
        $page->set_pagetype('site-index');
        $page->set_docs_path('');
        $page->set_context(context_course::instance(SITEID));
        $PAGE = $page;
        setup_utils::setup_page_blocks($page, self::HOMEPAGE_BLOCK_DEFINITION);
        $PAGE = $oldpage;
        // Rebuild the OUTPUT variable as if not $OUPUT->page is set to the last set page.
        // This will avoid an error message when the renderer is used later
        // and does not point the right page.
        $target = null;
        if ($PAGE->pagelayout === 'maintenance') {
            // If the page is using the maintenance layout then we're going to force target to maintenance.
            // This leads to a special core renderer that is designed to block access to API's that are likely unavailable for this
            // page layout.
            $target = RENDERER_TARGET_MAINTENANCE;
        }
        $OUTPUT = $PAGE->get_renderer('core', null, $target);
        // Setup carousel.
        static::setup_carousel();
    }

    /**
     * Setup config values
     */
    public static function setup_config_values() {
        foreach (self::DEFAULT_SETTINGS as $pluginname => $plugindefs) {
            $plugin = $pluginname;
            if ($pluginname === 'moodle') {
                $plugin = null;
            }
            foreach ($plugindefs as $key => $value) {
                $configvalue = get_config($plugin, $key);
                if ($configvalue != $value) {
                    set_config($key, $value, $plugin);
                }
            }
        }
    }

    /**
     * Setup Frontpage Carousel
     */
    public static function setup_carousel() {
        global $CFG;
        $context = context_system::instance();
        $fs = get_file_storage();
        $carouseldata = new \stdClass();
        foreach (self::CAROUSEL_DATA as $index => $slide) {
            $slideindex = $index + 1;
            $carouseldata = (object) array_merge(
                (array) $carouseldata, [
                "title$slideindex" => $slide['title'],
                "active$slideindex" => 1,
                "text$slideindex" => (object) [
                    "text" => $slide['text'],
                    "format" => FORMAT_HTML,
                ],
                "link$slideindex" => $slide['link'] ?? '',
            ]);
            $files = $fs->get_area_files($context->id, 'theme_enva', 'carousel', $slideindex, 'itemid, filepath,
                filename', false);
            $existing = array_filter($files, function($file) use ($slideindex) {
                return $file->get_filename() === 'slide' . $slideindex . '.jpg';
            });
            if ($existing) {
                foreach ($existing as $existingfile) {
                    $existingfile->delete();
                }
            }
            $file = setup_utils::upload_file($context->id, 'theme_enva', 'carousel', $slideindex,
                "{$CFG->dirroot}/theme/enva/{$slide['imagepath']}", "slide$slideindex.jpg");
            $carouseldata->{"image$slideindex"} = $file->get_filename();
        }
        $carouseldata->carouselenabled = 1;
        $carouseldata = json_encode($carouseldata);
        set_config('carouselconfig', $carouseldata, 'theme_enva');
    }
}