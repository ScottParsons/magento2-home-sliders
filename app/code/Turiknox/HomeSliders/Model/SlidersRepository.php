<?php
/*
 * Turiknox_Homesliders

 * @category   Turiknox
 * @package    Turiknox_Homesliders
 * @copyright  Copyright (c) 2017 Turiknox
 * @license    https://github.com/turiknox/magento2-home-sliders/blob/master/LICENSE.md
 * @version    1.0.0
 */
namespace Turiknox\HomeSliders\Model;

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
    protected $instances = [];

    /**
     * @var Sliders
     */
    protected $resource;

    /**
     * @var CollectionFactory
     */
    protected $slidersCollectionFactory;

    /**
     * @var SlidersSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var SlidersInterfaceFactory
     */
    protected $slidersInterfaceFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * SlidersRepository constructor.
     * @param ResourceSliders $resource
     * @param CollectionFactory $slidersCollectionFactory
     * @param SlidersSearchResultsInterfaceFactory $slidersSearchResultsInterfaceFactory
     * @param SlidersInterfaceFactory $slidersInterfaceFactory
     * @param DataObjectHelper $dataObjectHelper
     */
    public function __construct(
        ResourceSliders $resource,
        CollectionFactory $slidersCollectionFactory,
        SlidersSearchResultsInterfaceFactory $slidersSearchResultsInterfaceFactory,
        SlidersInterfaceFactory $slidersInterfaceFactory,
        DataObjectHelper $dataObjectHelper
    ) {
        $this->resource = $resource;
        $this->slidersCollectionFactory = $slidersCollectionFactory;
        $this->searchResultsFactory     = $slidersSearchResultsInterfaceFactory;
        $this->slidersInterfaceFactory  = $slidersInterfaceFactory;
        $this->dataObjectHelper         = $dataObjectHelper;
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
            $this->resource->save($slider);
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
        if (!isset($this->instances[$sliderId])) {
            /** @var \Turiknox\HomeSliders\Api\Data\SlidersInterface|\Magento\Framework\Model\AbstractModel $data */
            $data = $this->slidersInterfaceFactory->create();
            $this->resource->load($data, $sliderId);
            if (!$data->getId()) {
                throw new NoSuchEntityException(__('Requested slider doesn\'t exist'));
            }
            $this->instances[$sliderId] = $data;
        }
        return $this->instances[$sliderId];
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return \Turiknox\HomeSliders\Api\Data\SlidersSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        /** @var \Turiknox\HomeSliders\Api\Data\SlidersSearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);

        /** @var \Turiknox\HomeSliders\Model\ResourceModel\Sliders\Collection $collection */
        $collection = $this->slidersCollectionFactory->create();

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
            $dataDataObject = $this->slidersInterfaceFactory->create();
            $this->dataObjectHelper->populateWithArray($dataDataObject, $datum->getData(), SlidersInterface::class);
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
            unset($this->instances[$id]);
            $this->resource->delete($slider);
        } catch (ValidatorException $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        } catch (\Exception $e) {
            throw new StateException(
                __('Unable to remove slider %1', $id)
            );
        }
        unset($this->instances[$id]);
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
