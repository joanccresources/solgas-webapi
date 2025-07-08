<?php

namespace App\Traits;

use App\Utils\FieldProcessorWeb;
use App\Utils\PageMultipleContentProcessor;

trait ProcessesSectionRelations
{
    /**
     * Process section relations and their nested relationships.
     *
     * @param $sectionRels
     * @return void
     */
    public function processSectionRelations($sectionRels)
    {
        $sectionRels->each(function ($sectionRel) {
            $sectionRel->multipleFieldSectionRels->each(function ($multipleFieldSectionRel) {
                $multipleFieldSectionRel->multipleFieldRel->multipleContentRels =
                    $multipleFieldSectionRel->multipleFieldRel->multipleContentRels
                    ->sortBy('index') // Ordena por el campo `index`
                    ->map(function ($multipleContentRel) {
                        return PageMultipleContentProcessor::process($multipleContentRel, true);
                    });
            });

            $pageContent = $sectionRel->contentRels->pluck('value', 'variable_page_field');

            $sectionRel->contentRels = FieldProcessorWeb::processFields($sectionRel->fieldRels, $pageContent, with_someone_keys: false);
        });
    }
}
