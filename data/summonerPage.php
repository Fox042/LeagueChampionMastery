<?php

    // if summoner is set in the URL
    if(isset($_GET['summoner']) && $_GET['summoner'] != null){
        
        // remove php and html tags, as well as whitespace, then convert to lowercase
        $summonerName = strip_tags(preg_replace('/\s+/', '',(strtolower($_GET['summoner']))));

        // start the function to fetch summoner data
        getSummoner($summonerName, $chosen_region);
    } 
    // or else, show the "no summoner" page
    else {
        include('content/includes/noSummoner.php');
    }

    /*** FUNCTIONS ***/

    // get summoner name, id, profile icon, level
    function getSummoner($name, $region){
        
        // set summoner lookup URL
        $summonerLookupUrl = 'https://'.$region.'.api.pvp.net/api/lol/'.$region.'/v1.4/summoner/by-name/'.$name.'?api_key='.API_KEY;
        
        
        // get summoner data
        $request_s_data = file_get_contents($summonerLookupUrl);
        $summoner_data = json_decode($request_s_data, true);
        
        // extract the useful stuff (if the summoner exists)
        if (isset($summoner_data[$name]['id'])){
            
            $summonerId = $summoner_data[$name]['id'];
            $_SESSION['summonerName'] = $summoner_data[$name]['name'];
            $_SESSION['summonerIcon'] = $summoner_data[$name]['profileIconId'];
            $_SESSION['summonerLevel'] = $summoner_data[$name]['summonerLevel'];
        
            // move to the champion mastery function
            getChampionMasteries($summonerId, $region);
            
        } else {
            
            header("HTTP/1.0 404 Not Found");
            include('content/includes/noSummoner.php');
            
        }
        
    }


    // get champion mastery information for the chosen summoner
    function getChampionMasteries($id, $region){
        
        // get the platform id based on the region
        switch($region){
            case 'euw':
                $region_platform = 'EUW1';
                break;
                
            case 'eune':
                $region_platform = 'EUN1';
                break;
                
            case 'na':
                $region_platform = 'NA1';
        }
        
        // set champion mastery lookup URL
        $championMasteryUrl = 'https://'.$region.'.api.pvp.net/championmastery/location/'.$region_platform.'/player/'.$id.'/champions?&api_key='.API_KEY;
                
        // get champion mastery data
        $request_c_data = file_get_contents($championMasteryUrl);
        $champMastery_data = json_decode($request_c_data, true);
        
        // match champion id to champion key
        $request_championKey_data = file_get_contents('data/champions.json');
        $champKey_data = json_decode($request_championKey_data, true);
                
        //print_r($request_c_data);
        
        // if the session array already exists, clear it
        if (isset($_SESSION['champMasteryArray'])){
            
            unset($_SESSION['champMasteryArray']);
            $_SESSION['champMasteryArray'] = array();
            
        } else {
            
            $_SESSION['champMasteryArray'] = array();
            
        }
        
        $champMasteryLength = count($champMastery_data);
        
        // only get champion mastery data if there are 3 or more champions available
        if ($champMasteryLength >= 3){
            for($i = 0; $i < $champMasteryLength; $i++){

                // add champion data to an array in the user's session
                
                $_SESSION['champMasteryArray'][$i]['championId'] = $champMastery_data[$i]['championId'];
                
                $_SESSION['champMasteryArray'][$i]['championLevel'] = $champMastery_data[$i]['championLevel'];
               
                // prevent styling the points for more than the top 3 - not to take up extraneous space in the session
                if ($i < 3){
                    // styling the champion mastery points to show up as (e.g.) 12.3k, rather than the full number
                    $preChampPoints = $champMastery_data[$i]['championPoints'];

                     if ($preChampPoints > 999 && $preChampPoints <= 999999) {

                        $championPoints = round(floatval($preChampPoints / 1000), 1) . 'k';

                    } else {

                        $championPoints = $preChampPoints;

                    }
                } else {
                    $championPoints = null;
                }
                
                $_SESSION['champMasteryArray'][$i]['championPoints'] = $championPoints;
                
                $_SESSION['champMasteryArray'][$i]['championPointsRaw'] = number_format($champMastery_data[$i]['championPoints']);
                
                $_SESSION['champMasteryArray'][$i]['championChest'] = $champMastery_data[$i]['chestGranted'];
                
                $_SESSION['champMasteryArray'][$i]['championName'] = $champKey_data['champions'][0][($champMastery_data[$i]['championId'])]['name'];
                
                $_SESSION['champMasteryArray'][$i]['championKey'] = $champKey_data['champions'][0][($champMastery_data[$i]['championId'])]['key'];
                
            }
            
        }
        
        // show all the data that's been collected
        include('content/includes/summonerPage.php');
        
        // finally, unset the session now that the data has been loaded for the user
        unset($_SESSION['champMasteryArray']);
        
    }

    
?>