<?php
namespace Turiknox\HomeSliders\Model;
/*
 * Turiknox_Homesliders

 * @category   Turiknox
 * @package    Turiknox_Homesliders
 * @copyright  Copyright (c) 2017 Turiknox
 * @license    https://github.com/turiknox/magento2-home-sliders/blob/master/LICENSE.md
 * @version    1.0.0
 */
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\Search\FilterGroup;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\StateException;
use Magento\Framework\Exception\ValidatorException;
use Magento\Framework\Exception\NoSuchEntityException;
use Turiknox\HomeSliders\Api\SlidersRepositoryInterface;
use Turiknox\HomeSliders\Api\Data\SlidersInterface;
use Turiknox\HomeSliders\Api\Data\SlidersInterfaceFactory;
use Turiknox\HomeSliders\Api\Data\SlidersSearchResultsInterfaceFactory;
use Turiknox\HomeSliders\Model\ResourceModel\Sliders as ResourceSliders;
use Turiknox\HomeSliders\Model\ResourceModel\Sliders\CollectionFactory;

class SlidersRepository implements SlidersRepositoryInterface
{
    /**
     * @var array
     */
    protected $_instances = [];
    /**
     * @var Sliders
     */
    protected $_resource;
    /**
     * @var CollectionFactory
     */
    protected $_slidersCollectionFactory;
    /**
     * @var SlidersSearchResultsInterfaceFactory
     */
    protected $_searchResultsFactory;
    /**
     * @var SlidersInterfaceFactory
     */
    protected $_slidersInterfaceFactory;
    /**
     * @var DataObjectHelper
     */
    protected $_dataObjectHelper;

    public function __construct(
        ResourceSliders $resource,
        CollectionFactory $slidersCollectionFactory,
        SlidersSearchResultsInterfaceFactory $slidersSearchResultsInterfaceFactory,
        SlidersInterfaceFactory $slidersInterfaceFactory,
        DataObjectHelper $dataObjectHelper
    )
    {
        $this->_resource = $resource;
        $this->_slidersCollectionFactory = $slidersCollectionFactory;
        $this->_searchResultsFactory = $slidersSearchResultsInterfaceFactory;
        $this->_slidersInterfaceFactory = $slidersInterfaceFactory;
        $this->_dataObjectHelper = $dataObjectHelper;
    }

    /**
     * @param SlidersInterface $slider
     * @return SlidersInterface
     * @throws CouldNotSaveException
     */
    public function save(SlidersInterface $slider)
    {
        try {
            /** @var SlidersInterface|\Magento\Framework\Model\AbstractModel $slider */
            $this->_resource->save($slider);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the slider: %1',
                $exception->getMessage()
            ));
        }
        return $slider;
    }

    /**
     * Get slider record
     *
     * @param $sliderId
     * @return mixed
     * @throws NoSuchEntityException
     */
    public function getById($sliderId)
    {
        if (!isset($this->_instances[$sliderId])) {
            /** @var \Turiknox\HomeSliders\Api\Data\SlidersInterface|\Magento\Framework\Model\AbstractModel $data */
            $data = $this->_slidersInterfaceFactory->create();
            $this->_resource->load($data, $sliderId);
            if (!$data->getId()) {
                throw new NoSuchEntityException(__('Requested slider doesn\'t exist'));
            }
            $this->_instances[$sliderId] = $data;
        }
        return $this->_instances[$sliderId];
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return \Turiknox\HomeSliders\Api\Data\SlidersSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        /** @var \Turiknox\HomeSliders\Api\Data\SlidersSearchResultsInterface $searchResults */
        $searchResults = $this->_searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);

        /** @var \Turiknox\HomeSliders\Model\ResourceModel\Sliders\Collection $collection */
        $collection = $this->_slidersCollectionFactory->create();

        //Add filters from root filter group to the collection
        /** @var FilterGroup $group */
        foreach ($searchCriteria->getFilterGroups() as $group) {
            $this->addFilterGroupToCollection($group, $collection);
        }
        $sortOrders = $searchCriteria->getSortOrders();
        /** @var SortOrder $sortOrder */
        if ($sortOrders) {
            foreach ($searchCriteria->getSortOrders() as $sortOrder) {
                $field = $sortOrder->getField();
                $collection->addOrder(
                    $field,
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        } else {
            $field = 'slider_id';
            $collection->addOrder($field, 'ASC');
        }
        $collection->setCurPage($searchCriteria->getCurrentPage());
        $collection->setPageSize($searchCriteria->getPageSize());

        $data = [];
        foreach ($collection as $datum) {
            $dataDataObject = $this->_slidersInterfaceFactory->create();
            $this->_dataObjectHelper->populateWithArray($dataDataObject, $datum->getData(), SlidersInterface::class);
            $data[] = $dataDataObject;
        }
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults->setItems($data);
    }

    /**
     * @param SlidersInterface $slider
     * @return bool
     * @throws CouldNotSaveException
     * @throws StateException
     */
    public function delete(SlidersInterface $slider)
    {
        /** @var \Turiknox\HomeSliders\Api\Data\SlidersInterface|\Magento\Framework\Model\AbstractModel $slider */
        $id = $slider->getId();
        try {
            unset($this->_instances[$id]);
            $this->_resource->delete($slider);
        } catch (ValidatorException $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        } catch (\Exception $e) {
            throw new StateException(
                __('Unable to remove slider %1', $id)
            );
        }
        unset($this->_instances[$id]);
        return true;
    }

    /**
     * @param $dataId
     * @return bool
     */
    public function deleteById($dataId)
    {
        $data = $this->getById($dataId);
        return $this->delete($data);
    }
}