<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');

/**
 * Frees Controller
*/
class Jea_ExportControllerFrees extends JControllerAdmin
{
	/**
	 * Proxy for getModel.
	 * @since       2.5
	 */
	public function getModel($name = 'Free', $prefix = 'Jea_ExportModel', $config = Array())
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}
	
	
	public function putLinePoliris($file, $champs)
	{
		foreach($champs as $champ)
		{
			fwrite($file, '"'.$champ.'"!#');
		}
		fwrite($file, chr(27));
	}
	
	
	public function exportByPasserelle($annoncesArray, $infos, $pasrl_ref)
	{
		if(!empty($annoncesArray))
		{
			//verify if the export dir exist
			!file_exists('exports') ? mkdir('exports') : '';
			!file_exists('./exports/'.$pasrl_ref) ? mkdir('./exports/'.$pasrl_ref) : '';
			
			$info = $infos[0];
			
			switch($info->method)
			{
				//cas de la methode poliris
				case 'poliris':
					// creation d'un tableau de 255 cases pour la creation du csv poliris
					$champsCSV = array_fill(0, 254, '');
					$file = fopen('./exports/'.$pasrl_ref.'/'.$info->code_agence.'.csv', 'w');
					
					// fill the file with annonces infos
					foreach($annoncesArray AS $annonce)
					{
						$champsCSV[0] = $info->code_agence;
						$champsCSV[1] = $annonce->ref;
						switch($annonce->transaction_type)
						{
							case 'SELLING':
								$champsCSV[2] = 'Vente';
								break;
							default:
								$champsCSV[2] = 'Location';
								break;
						}
						$champsCSV[3] = $annonce->type;
						$champsCSV[4] = $annonce->zip_code;
						$champsCSV[5] = $annonce->town;
						$champsCSV[6] = 'France';
						$champsCSV[7] = $annonce->address;
						$champsCSV[10] = $annonce->price;
						$champsCSV[14] = $annonce->fees;
						$champsCSV[15] = $annonce->living_space;
						$champsCSV[16] = $annonce->land_space;
						$champsCSV[17] = $annonce->rooms;
						$champsCSV[18] = $annonce->bedrooms;
						$champsCSV[19] = $annonce->title;
						$champsCSV[20] = str_replace(chr(13), '<br/>', $annonce->description);
						$champsCSV[20] = str_replace(chr(10), '<br/>', $champsCSV[20]);
						$champsCSV[21] = date("d/m/Y", strtotime($annonce->availability));
						$champsCSV[23] = $annonce->floor;
						$champsCSV[24] = $annonce->floors_number;
						$champsCSV[28] = $annonce->bathrooms;
						$champsCSV[30] = $annonce->toilets;
						$champsCSV[32] = $annonce->heating_type;
						$champsCSV[33] = $annonce->cook;
						$champsCSV[175] = $annonce->dpe_energy;
						$champsCSV[178] = $annonce->dpe_ges;
						
						
						//amenities
						$amenities = explode('-', $annonce->amenities);
						$tab_amenities = array_fill(1,12, 'NON');
						if(!empty($amenities))
						{
							foreach($amenities as $amenitie)
							{
								$tab_amenities[$amenitie] = 'OUI';
							}
						}
						$champsCSV[40] = $tab_amenities[1];
						$champsCSV[41] = $tab_amenities[2];
						if($tab_amenities[3] == 'OUI')
							$champsCSV[42] = '1';
						$champsCSV[44] = $tab_amenities[4];
						$champsCSV[45] = $tab_amenities[5];
						$champsCSV[46] = $tab_amenities[6];
						$champsCSV[47] = $tab_amenities[7];
						$champsCSV[60] = $tab_amenities[8];
						$champsCSV[63] = $tab_amenities[9];
						$champsCSV[64] = $tab_amenities[10];
						$champsCSV[65] = $tab_amenities[11];
						$champsCSV[67] = $tab_amenities[12];
						
						// gestion des images
						$id = $annonce->id;
						$images = (array) json_decode($annonce->images);
						if (count($images) > 9)
							$limit = 9;
						else
							$limit = count($images);
						$i = 0;
						$champ_photo = 84;
						$champ_titre = 93;
						while($i<$limit)
						{
							$champsCSV[$champ_photo] = 'http://www.' . $_SERVER['SERVER_NAME'] . '/images/com_jea/images/' . $id . '/' . $images[$i]->name;
							$champsCSV[$champ_titre] = $images[$i]->title;
							$champ_titre++;
							$champ_photo++;
							$i++;
						}
						
						
						$champsCSV[174] = $annonce->ref;
						if (isset($annonce->seller_name))
							$champsCSV[113] = $annonce->seller_name;
						if (isset($annonce->phone))
							$champsCSV[119] = $annonce->phone;
						if (isset($annonce->manda_date))
							$champsCSV[112] = date("d/m/Y", strtotime($annonce->manda_date));
						$this->putLinePoliris($file, $champsCSV);
					}
					fclose($file);
					
					// creation du zip
					$zip = new ZipArchive();
					$zip->open('./exports/'.$pasrl_ref.'/'.$info->code_agence.'.zip', ZIPARCHIVE::CREATE);
					$zip->addFile('./exports/'.$pasrl_ref.'/'.$info->code_agence.'.csv', $info->code_agence.'.csv');
					$zip->close();
					
					// envoi vers le FTP prestataire
// 					$ftp = ftp_connect('ftpperso.free.fr', '21');
// 					ftp_login($ftp, 'denquin.jeremy', '160988');
// 					ftp_nb_put($ftp, $info->code_agence.'.zip', './exports/'.$pasrl_ref.'/'.$info->code_agence.'.zip', FTP_BINARY);
// 					ftp_close($ftp);
					break;
					
				case 'webimmo':
					// creation du fichier xml
					$xml = new DOMDocument('1.0', 'iso-8859-1');
					$xml->formatOutput = true;
					
					//racine du fichier xml
					$root = $xml->createElement('Script_PAG_XML');
					$root = $xml->appendChild($root);
					
					foreach ($annoncesArray as $annonce)
					{
						$annonces = $xml->createElement('annonces');
						$annonces = $root->appendChild($annonces);
						
						$annonces->appendChild($xml->createElement('id_dept', utf8_encode($annonce->department_id)));
						$annonces->appendChild($xml->createElement('id_categorie', utf8_encode($annonce->type)));
						$annonces->appendChild($xml->createElement('id_compte', utf8_encode($info->num_boutique)));
						$annonces->appendChild($xml->createElement('email', utf8_encode($annonce->email)));
						$annonces->appendChild($xml->createElement('password', utf8_encode($info->code_agence)));
						$annonces->appendChild($xml->createElement('code_postal', utf8_encode($annonce->zip_code)));
						$annonces->appendChild($xml->createElement('ville', utf8_encode($annonce->town)));
						$annonces->appendChild($xml->createElement('statut', '2'));
						$annonces->appendChild($xml->createElement('societe', utf8_encode('')));// a definir
						$annonces->appendChild($xml->createElement('siret', ''));// a definir
						$annonces->appendChild($xml->createElement('nom', utf8_encode($annonce->nom)));
						$annonces->appendChild($xml->createElement('tel', ''));// a definir
						$annonces->appendChild($xml->createElement('titre', utf8_encode($annonce->title)));
						$texte = str_replace('&rsquo;', '\'', $annonce->description);
						$texte = str_replace('&ndash;', ',', $texte);
						$texte = str_replace('&hellip;', '', $texte);
						$texte = str_replace('&lt;', '<', $texte);
						$texte = str_replace('&gt;', '>', $texte);
						$annonces->appendChild($xml->createElement('texte', utf8_encode($texte)));
						$annonces->appendChild($xml->createElement('prix', utf8_encode($annonce->price)));
						$annonces->appendChild($xml->createElement('tel_cache', 'N'));
						
						//gestion des images
						$id = $annonce->id;
						$images = (array) json_decode($annonce->images);
						$nb_images = count($images);
						if ($nb_images > 5)
							$limit = 5;
						else
							$limit = $nb_images;
						$i = 1;
						$j = 0;
						while($i<=$limit)
						{
							$annonces->appendChild($xml->createElement('photo'.$i, 'http://www.' . $_SERVER['SERVER_NAME'] . '/images/com_jea/images/' . $id . '/' . $images[$j]->name));
							$i++;
							$j++;
						}
						
						$annonces->appendChild($xml->createElement('ref_agence', $info->code_agence));
						$annonces->appendChild($xml->createElement('ref_bien', utf8_encode($annonce->ref)));
						$annonces->appendChild($xml->createElement('dpe', utf8_encode($annonce->dpe_energy)));
						$annonces->appendChild($xml->createElement('ges', utf8_encode($annonce->dpe_ges)));
						
						//gestion des amenities
						$amenities = explode('-', $annonce->amenities);
						$tab_amenities = array_fill(1,12, 'NON');
						if(!empty($amenities))
						{
							foreach($amenities as $amenitie)
							{
								$tab_amenities[$amenitie] = 'OUI';
							}
						}
						$annonces->appendChild($xml->createElement('piscine', $tab_amenities[10]));
						$annonces->appendChild($xml->createElement('garage', $tab_amenities[3]));
						
						
						$annonces->appendChild($xml->createElement('surface', utf8_encode($annonce->living_space)));
						$annonces->appendChild($xml->createElement('annee', ''));// a definir
						$annonces->appendChild($xml->createElement('pieces', utf8_encode($annonce->rooms)));
						$annonces->appendChild($xml->createElement('nb_chambres', utf8_encode($annonce->bedrooms)));
						$annonces->appendChild($xml->createElement('nb_bains', utf8_encode($annonce->bathrooms)));
						$annonces->appendChild($xml->createElement('surf_terrain', utf8_encode($annonce->land_space)));
					}
					//sauvegarde du fichier xml
					$xml->save("./exports/$pasrl_ref/" . $info->code_agence . ".xml");
					break;
					
				case 'trovit':
					// creation du fichier xml
					$xml = new DOMDocument('1.0', 'iso-8859-1');
					$xml->formatOutput = true;
							
					//racine du fichier xml
					$root = $xml->createElement('trovit');
					$root = $xml->appendChild($root);
					
					foreach ($annoncesArray as $annonce)
					{
						$ad = $xml->createElement('ad');
						$ad = $root->appendChild($ad);
						
						$ad->appendChild($xml->createElement('id', utf8_encode($annonce->ref)));
						$link = 'http://www.' . $_SERVER['SERVER_NAME'] . '/index.php?option=com_jea&amp;view=property&amp;id=' . $annonce->id . ':' . $annonce->alias;
						$ad->appendChild($xml->createElement('url', $link));
						$ad->appendChild($xml->createElement('title', utf8_encode($annonce->title)));
						if ($annonce->transaction_type == 'SELLING')
							$type = 'For Sale';					
						if ($annonce->transaction_type == 'RENTING')
							$type = 'For Rent';
						$ad->appendChild($xml->createElement('type', utf8_encode($type)));
						
						//suppression des caracteres speciaux de la description
						$texte = str_replace('&rsquo;', '\'', $annonce->description);
						$texte = str_replace('&ndash;', ',', $texte);
						$texte = str_replace('&hellip;', '', $texte);
						$texte = str_replace('&lt;', '<', $texte);
						$texte = str_replace('&gt;', '>', $texte);
						
						$ad->appendChild($xml->createElement('content', utf8_encode($texte)));
						$ad->appendChild($xml->createElement('price', utf8_encode($annonce->price)));
						$ad->appendChild($xml->createElement('floor_number', utf8_encode($annonce->floor)));
						$ad->appendChild($xml->createElement('city', utf8_encode($annonce->town)));
						$ad->appendChild($xml->createElement('region', utf8_encode($annonce->department)));
						$ad->appendChild($xml->createElement('postcode', utf8_encode($annonce->zip_code)));
						$ad->appendChild($xml->createElement('latitude', utf8_encode($annonce->latitude)));
						$ad->appendChild($xml->createElement('longitude', utf8_encode($annonce->longitude)));
						
						$floor_area = $xml->createElement('floor_area', utf8_encode($annonce->living_space));
						$floor_area_attribute = $xml->createAttribute('unit');
						$floor_area_attribute->value = 'meters';
						$floor_area->appendChild($floor_area_attribute);
						$ad->appendChild($floor_area);
						
						$plot_area = $xml->createElement('plot_area', utf8_encode($annonce->land_space));
						$plot_area_attribute = $xml->createAttribute('unit');
						$plot_area_attribute->value='meters';
						$plot_area->appendChild($plot_area_attribute);
						$ad->appendChild($plot_area);
						
						$ad->appendChild($xml->createElement('rooms', utf8_encode($annonce->rooms)));
						$ad->appendChild($xml->createElement('bathrooms', utf8_encode($annonce->bathrooms)));
						$ad->appendChild($xml->createElement('eco_score', utf8_encode($annonce->dpe_energy)));
						
						// gestion des images
						$images = (array) json_decode($annonce->images);
						$nb_images = count($images);
						$pictures = $xml->createElement('pictures');
						$picture = $xml->createElement('picture');
						$picture_featured = $xml->createAttribute('featured');
						$picture_featured->value = 'true';
						$picture->appendChild($picture_featured);
						$picture_url = $xml->createElement('picture_url', 'http://www.' . $_SERVER['SERVER_NAME'] . '/images/com_jea/images/' . $id . '/' . $images[0]->name);
						$picture->appendChild($picture_url);
						$pictures->appendChild($picture);
						$i = 1;
						while($i<$nb_images)
						{
							$picture = $xml->createElement('picture');
							$picture_url = $xml->createElement('picture_url', 'http://www.' . $_SERVER['SERVER_NAME'] . '/images/com_jea/images/' . $id . '/' . $images[$i]->name);
							$picture->appendChild($picture_url);
							$pictures->appendChild($picture);
							$i++;
						}
						$ad->appendChild($pictures);						
					}
					$xml->save("./exports/$pasrl_ref/" . $info->code_agence . ".xml");
					break;
			}
		}	
		return count($annoncesArray);
	}
	
	/**
	 * Method to export data
	 */
	public function exporter()
	{
		// set the toolbar title
		JToolBarHelper::title(JText::_('COM_JEA_EXPORT_IN_PROGRESS'));
		
		// print the message
		echo '<h2>' . JText::_('COM_JEA_EXPORT_IN_PROGRESS') . '</h2>';
		$this->display();
		
		// get the model
		$model = $this->getModel();
		
		// call the model function getPasserellesActives
		$passerelles = $model->getPasserellesActives();
		
		$msg_retour = '';
		
		// get the annonce list activated for the passerelle
		foreach ($passerelles AS $passerelle)
		{
			//get the pasrl ref
			$pasrl_ref = $passerelle->pasrl_ref;
		
			// function to export
			$nb_annonces = $this->exportByPasserelle(
					// get the annonces activated to this passerelle
					$annonces = $model->getAnnoncesByPasserelle($pasrl_ref),
					// get the infos of this passerelle (method, ftp,...)
					$model->getInfosFree($pasrl_ref),
					$pasrl_ref
			);
			
			if ($nb_annonces != 0)
			{
				//increment nb_export and date_last_export
				$model->updateExport($passerelle->id);
				$msg_retour .= "$nb_annonces biens ont ete exportes vers " . $passerelle->name . "<br/>";
			}			
		}
		
		// redirect to the view Frees
 		$this->setRedirect(JRoute::_('index.php?option=com_jea_export&view=frees', false), $msg_retour);
	}
}