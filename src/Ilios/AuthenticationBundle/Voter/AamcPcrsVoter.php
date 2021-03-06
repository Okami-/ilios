<?php

namespace Ilios\AuthenticationBundle\Voter;

use Ilios\CoreBundle\Entity\AamcPcrsInterface;
use Ilios\CoreBundle\Entity\UserInterface;

/**
 * Class AamcPcrsVoter
 * @package Ilios\AuthenticationBundle\Voter
 */
class AamcPcrsVoter extends AbstractVoter
{
    /**
     * {@inheritdoc}
     */
    protected function getSupportedClasses()
    {
        return array('Ilios\CoreBundle\Entity\AamcPcrsInterface');
    }

    /**
     * @param string $attribute
     * @param AamcPcrsInterface $aamcPcrs
     * @param UserInterface $user
     * @return bool
     */
    protected function isGranted($attribute, $aamcPcrs, $user = null)
    {
        if (!$user instanceof UserInterface) {
            return false;
        }

        // all authenticated users can view PCRS,
        // but only developers can create/modify/delete them directly.
        switch ($attribute) {
            case self::VIEW:
                return true;
                break;
            case self::CREATE:
            case self::EDIT:
            case self::DELETE:
                return $this->userHasRole($user, ['Developer']);
                break;
        }

        return false;
    }
}
