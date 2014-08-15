<?php


namespace JUMA\Bundle\PingBundle\Entity\Normalizer;


use HS\PasswordLessBundle\Entity\Player;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\scalar;

class PlayerNormalizer implements NormalizerInterface
{
    /**
     * Normalizes an object into a set of arrays/scalars
     *
     * @param object $object object to normalize
     * @param string $format format the normalization result will be encoded as
     * @param array $context Context options for the normalizer
     *
     * @return array|scalar
     */
    public function normalize($object, $format = null, array $context = array())
    {
        return array(
            'id' => $object->getId(),
            'name' => $object->getName(),
            'rating' => $object->getRating(),
        );
    }

    /**
     * Checks whether the given class is supported for normalization by this normalizer
     *
     * @param mixed $data Data to normalize.
     * @param string $format The format being (de-)serialized from or into.
     *
     * @return Boolean
     */
    public function supportsNormalization($data, $format = null)
    {

        return $data instanceof Player;
    }

} 