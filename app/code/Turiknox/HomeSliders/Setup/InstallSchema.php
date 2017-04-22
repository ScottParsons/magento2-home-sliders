<?php
namespace Turiknox\HomeSliders\Setup;
/*
 * Turiknox_Homesliders

 * @category   Turiknox
 * @package    Turiknox_Homesliders
 * @copyright  Copyright (c) 2017 Turiknox
 * @license    https://github.com/turiknox/magento2-home-sliders/blob/master/LICENSE.md
 * @version    1.0.0
 */
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        $tableName = $installer->getTable('turiknox_homesliders_sliders');

        if (!$installer->tableExists('turiknox_homesliders_sliders')) {
            $table = $installer->getConnection()
                ->newTable($tableName)
                ->addColumn(
                    'slider_id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'primary' => true
                    ],
                    'Slider ID'
                )
                ->addColumn(
                    'title',
                    Table::TYPE_TEXT,
                    255,
                    array(
                        'nullable'  => false,
                    ),
                    'Title'
                )
                ->addColumn(
                    'image',
                    Table::TYPE_TEXT,
                    255,
                    array(
                        'nullable'  => false,
                    ),
                    'Image'
                )
                ->addColumn(
                    'image_label',
                    Table::TYPE_TEXT,
                    255,
                    array(
                        'nullable'  => false,
                    ),
                    'Image Label'
                )
                ->addColumn(
                    'url',
                    Table::TYPE_TEXT,
                    255,
                    array(
                        'nullable'  => false,
                    ),
                    'URL'
                )
                ->addColumn(
                    'html',
                    Table::TYPE_TEXT,
                    255,
                    array(
                        'nullable'  => false,
                    ),
                    'HTML'
                )
                ->addColumn(
                    'sort_order',
                    Table::TYPE_SMALLINT,
                    null,
                    array(
                        'nullable'  => false,
                        'default' => 0
                    ),
                    'Sort Order'
                )
                ->addColumn(
                    'is_enabled',
                    Table::TYPE_BOOLEAN,
                    null,
                    array(
                        'nullable'  => false,
                    ),
                    'Status'
                );
            $installer->getConnection()->createTable($table);
        }
        $installer->endSetup();
    }
}