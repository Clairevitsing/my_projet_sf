<?php

namespace App\Security\Voter;

use LogicException;
use App\Entity\User;
use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Security\Permission;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;


class ArticleVoter extends Voter
{
    public const EDIT = 'ARTICLE_EDIT';
    public const DELETE = 'ARTICLE_DELETE';

    public function __construct(
        private Security $security
    ) {
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::DELETE])
            && $subject instanceof Article;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof User) {
            return false;
        }

        // if (!$subject instanceof Article) {
        //     throw new LogicException("Wrong subject type provided");
        // // // }
        // if ($attribute === Permission::EA_EXECUTE_ACTION) {
        // }

        // if ($subject instanceof Article) {
        //     throw new LogicException("Wrong subject type provided");
        // }

        // if ($this->security->isGranted('ROLE_ADMIN') || $subject->getAuthor() === $user) {
        //     return true;
        // }


        if ($this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }
        if ($attribute === self::EDIT || $subject->getAuthor() === $user) {
            return true;
        }
        return false;
    }
}
