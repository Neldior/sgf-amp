<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Utilisateur
 *
 * @author stag
 */
class Utilisateur {
    //put your code here
    private $iduser;
    private $civilite;
    private $matricule;
    private $password;
    private $nomuser;
    private $prenomuser;
    private $adresseuser;
    private $emailuser;
    private $teluser;
    
    public function __construct($iduser,$civilite,$matricule,$password,$nomuser,$prenomuser,$adresseuser,$emailuser,$teluser) {
        $this->iduser = $iduser;
        $this->civilite = $civilite;
        $this->matricule = $matricule;
        $this->password = $password;
        $this->nomuser = $nomuser;
        $this->prenomuser = $prenomuser;
        $this->adresseuser = $adresseuser;
        $this->emailuser = $emailuser;
        $this->teluser = $teluser;
    }
    
    public function getIduser(){
        return $this->iduser;
    }
    public function setIduser($id){
        $this->iduser = $id;
    }
    
    public function getCivilite(){
        return $this->civilite;
    }
    public function setCivilite($civil){
        $this->civilite = $civil;
    }
    
    public function getMatricule(){
        return $this->matricule;
    }
    public function setMatricule($mat){
        $this->matricule = $mat;
    }
    
    public function getPassword(){
        return $this->password;
    }
    public function setPassword($pwd){
        $this->password = $pwd;
    }
    
    public function getNomuser(){
        return $this->nomuser;
    }
    public function setNomuser($nom){
        $this->nomuser = $nom;
    }
    
    public function getPrenomuser(){
        return $this->prenomuser;
    }
    public function setPrenomuser($prenom){
        $this->prenomuser = $prenom;
    }
    
    public function getAdresseuser(){
        return $this->adresseuser;
    }
    public function setAdresseuser($adresse){
        $this->adresseuser = $adresse;
    }
    
    public function getEmailuser(){
        return $this->emailuser;
    }
    public function setEmailuser($mail){
        $this->emailuser = $mail;
    }
    
    public function getTeluser(){
        return $this->teluser;
    }
    public function setTeluser($tel){
        $this->teluser = $tel;
    }

}


