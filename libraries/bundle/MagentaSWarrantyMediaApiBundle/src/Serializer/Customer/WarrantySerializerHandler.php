<?php
namespace Magenta\Bundle\SWarrantyMediaApiBundle\Serializer\Customer;

use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityRepository;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Customer\Warranty;
use Magenta\Bundle\SWarrantyModelBundle\Entity\Organisation\Organisation;
use Sonata\CoreBundle\Serializer\BaseSerializerHandler;
use JMS\Serializer\Context;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\VisitorInterface;
use Sonata\CoreBundle\Model\ManagerInterface;
use Sonata\CoreBundle\Serializer\SerializerHandlerInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @author Sylvain Deloux <sylvain.deloux@ekino.com>
 */
class WarrantySerializerHandler
	implements SerializerHandlerInterface {
	/**
	 * @var ObjectRepository
	 */
	protected $repo;
	
	/**
	 * @var string[]
	 */
	protected static $formats = [ 'json', 'xml', 'yml' ];
	
	/**
	 * @param RegistryInterface $registry
	 */
	public function __construct(RegistryInterface $registry) {
		$this->repo = $registry->getRepository(Warranty::class);
	}
	
	public static function getSubscribingMethods() {
		$type    = static::getType();
		$methods = [];
		
		foreach(static::$formats as $format) {
			$methods[] = [
				'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
				'format'    => $format,
				'type'      => $type,
				'method'    => 'serializeObjectToId',
			];
			
			$methods[] = [
				'direction' => GraphNavigator::DIRECTION_DESERIALIZATION,
				'format'    => $format,
				'type'      => $type,
				'method'    => 'deserializeObjectFromId',
			];
		}
		
		return $methods;
	}
	
	/**
	 * Serialize data object to id.
	 *
	 * @param object $data
	 *
	 * @return int|null
	 */
	public function serializeObjectToId(VisitorInterface $visitor, $data, array $type, Context $context) {
		if($data instanceof Warranty) {
			return $visitor->visitInteger($data->getId(), $type, $context);
		}
	}
	
	/**
	 * Deserialize object from its id.
	 *
	 * @param int $data
	 *
	 * @return null|object
	 */
	public function deserializeObjectFromId(VisitorInterface $visitor, $data, array $type) {
		return $this->repo->findOneBy([ 'id' => $data ]);
	}
	
	/**
	 * {@inheritdoc}
	 */
	public static function getType() {
		return 'magenta_customer_warranty_id';
	}
} //magenta_customer_service_sheet_id
