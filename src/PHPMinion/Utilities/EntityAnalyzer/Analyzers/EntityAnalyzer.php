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

use PHPMinion\Utilities\EntityAnalyzer\Models\EntityModel;
use PHPMinion\Utilities\EntityAnalyzer\Models\ObjectModel;
use PHPMinion\Utilities\EntityAnalyzer\Factories\AnalyzerFactory;
use PHPMinion\Utilities\EntityAnalyzer\Factories\RendererFactory;
use PHPMinion\Utilities\EntityAnalyzer\Exceptions\AnalyzerException;

/**
 * Class EntityAnalyzer
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
class EntityAnalyzer implements AnalyzerInterface
{

    /**
     * Current entity being analyzed
     *
     * @var ObjectModel
     */
    private $_objectModel;

    /**
     * Analyzes an entity and returns the rendered results
     *
     * Analyze() and Render() have been split off into separate
     * methods to allow for recursive analysis.
     *
     * @param  mixed  $entity
     * @return string
     * @throws AnalyzerException
     */
    public function analyzeAndRender($entity)
    {
        $model = $this->analyze($entity);

        return $this->render($model);
    }

    /**
     * @inheritDoc
     * @throws AnalyzerException
     */
    public function analyze($entity)
    {
        \PHPMinion\Utilities\Dbug\Dbug::type($entity, "entity type:")->ignore()->dump();
        \PHPMinion\Utilities\Dbug\Dbug::trace("entity type trace:", 15)->ignore()->dump();
        /*
        if (gettype($entity) === 'array') {
            \PHPMinion\Utilities\Dbug\Dbug::trace("array entity type:", 15)->ignore()->dump();
            \PHPMinion\Utilities\Dbug\Dbug::dbug($entity, "array entity dbug data:")->ignore()->dump();
        }
        */

        $this->validateEntityType($entity);
        $analyzer = AnalyzerFactory::getAnalyzer($entity);

        \PHPMinion\Utilities\Dbug\Dbug::type($analyzer, "entity analyzer type:")->ignore()->dump();
        /*
        $this->_objectModel = $analyzer->analyze($entity);
        return $this->_objectModel;
        */

        return $analyzer->analyze($entity);
    }

    /**
     * Converts an EntityModel into viewable results
     *
     * @param  EntityModel $model
     * @return string
     */
    public function render(EntityModel $model)
    {
        $renderer = RendererFactory::getModelRenderer($model);

        \PHPMinion\Utilities\Dbug\Dbug::type($renderer, "renderer type in entityanalyzer->render():")->ignore()->dump();

        return $renderer->renderModel($model);
    }

    /**
     * Verifies that the target entity is a workable data type
     *
     * @param  mixed $entity
     * @return bool
     * @throws AnalyzerException
     */
    private function validateEntityType($entity)
    {
        if (!is_object($entity) && !is_array($entity)) {
            throw new AnalyzerException("EntityAnalyzer only accepts objects or arrays: '" . gettype($entity) . "' provided.");
        }

        return true;
    }

}