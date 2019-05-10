<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

class UserFixures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $length = 10;
        $random = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
        $user = new User();
        $user->setGuid(Uuid::uuid4());
        $user->setCreatedat(new \DateTime());
        $user->setCreatedby('1');
        $user->setUpdatedat(new \DateTime());
        $user->setName('Bilal');
        $user->setDob(new \DateTime());
        $user->setPassword($random);
        $user->setEmail('x@y.com');
         $manager->persist($user);

        $manager->flush();
    }



}
