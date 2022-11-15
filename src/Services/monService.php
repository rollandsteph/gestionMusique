<?php 
use Symfony\Component\Security\Core\Security;

class ExampleService
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function maMethodeDuService()
    {
        if ($this->security->isGranted('ROLE_ADMIN')){
            //....
        }
    }
    
}