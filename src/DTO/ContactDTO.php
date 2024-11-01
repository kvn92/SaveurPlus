<?php 

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;


class ContactDTO{


    #[Assert\NotBlank()]
    #[Assert\Length(min:4,max:20,minMessage:'4 minimux ',maxMessage:'20 caractères Maximum')]
    public string $name ="";

    #[Assert\NotBlank()]   
    public string $email ="";


    #[Assert\NotBlank()]   
    public string $service ="";


    #[Assert\NotBlank()]  
    #[Assert\Length(min:10,max:200,minMessage:'10 minimux ',maxMessage:'200 caractères Maximum')]
    public string $message ="";
}