<?php
namespace Magenta\Bundle\SWarrantyModelBundle\Entity\AccessControl;

interface ACModuleInterface {
	
	public function getModuleName(): string;
	
	public function getModuleCode(): string;
	
	public function getSupportedModuleActions(): array;
}