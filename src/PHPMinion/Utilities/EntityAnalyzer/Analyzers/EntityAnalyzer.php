<?php
/**
 * PHPMinion
 *
 * A suite of tools to facilitate development and debugging.
 *
 * @package     PHPMinion
 * @author      Evan Johnson
 * @created     October 9, 2015
 * @version     0.1
 */

namespace PHPMinion\Utilities\EntityAnalyzer\Analyzers;

use PHPMinion\Utilities\EntityAnalyzer\Models\DataTypeModel;
use PHPMinion\Utilities\EntityAnalyzer\Models\ObjectModel;
use PHPMinion\Utilities\EntityAnalyzer\Factories\AnalyzerFactory;
use PHPMinion\Utilities\EntityAnalyzer\Factories\RendererFactory;
use PHPMinion\Utilities\EntityAnalyzer\Exceptions\EntityAnalyzerException;

/**
 * Class EntityEntityAnalyzer
 *
 * Entry point for entity analysis.
 * Calls the proper analysis handlers for various datatypes that
 * need more rigorous handling.
 *
 * @package     PHPMinion
 * @author      Evan Johnson
 * @created     October 18, 2015
 * @version     0.1
 */
class EntityAnalyzer implements EntityAnalyzerInterface
{

    /**
     * Analyzes an entity and returns the rendered results
     *
     * Analyze() and Render() have been split off into separate
     * methods to allow for recursive analysis.
     *
     * @param  mixed  $entity
     * @return string
     * @throws EntityAnalyzerException
     */
    public function analyzeAndRender($entity)
    {
        $model = $this->analyze($entity);

        return $this->render($model);
    }

    /**
     * @inheritDoc
     * @throws EntityAnalyzerException
     */
    public function analyze($entity)
    {
        $analyzer = AnalyzerFactory::getAnalyzer($entity);

        return $analyzer->analyze($entity);
    }

    /**
     * Converts an DataTypeModel into viewable results
     *
     * @param  DataTypeModel $model
     * @return string
     */
    public function render(DataTypeModel $model)
    {
        $renderer = RendererFactory::getModelRenderer($model);

        \PHPMinion\Utilities\Dbug\Dbug::type($renderer, "renderer type in entityanalyzer->render():")->ignore()->dump();

        return $renderer->renderModel($model);
    }

}