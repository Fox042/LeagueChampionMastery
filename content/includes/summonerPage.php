<div class="container">
    
    <div class="main_content">

        <!-- The background image for the header will be one of the user's top three champions, randomly selected -->
        <div id="userHeader" style="background-image: linear-gradient( rgba(0, 0, 0, 0.25), rgba(0, 0, 0, 0.25) ), url('content/assets/splash/<?php echo $_SESSION['champMasteryArray'][rand(0, 2)]['championKey']; ?>_0.jpg')"></div>

        <!-- display the avatar, username, and level of the summoner -->
        <div id="userName_c">
            <img id="userImage" src="content/assets/profileicon/<?php echo $_SESSION['summonerIcon']; ?>.png" onerror="this.src='content/assets/profileicon/1.png';" />
                <h1 id="userName"><?php echo $_SESSION['summonerName']; ?></h1>
                <span id="userLevel">Level <?php echo $_SESSION['summonerLevel']; ?></span>
        </div>

        <?php if (count($_SESSION['champMasteryArray']) < 3) : ?>

        <!-- if there are no top 3 champions available, then it's a safe bet there isn't enough data -->
        Not enough variables. Not nearly enough variables.

        <?php else : ?>

        <h2>Top 3 champions</h2>
        <div class="hr_fade"></div>
        <!-- Section holding the user's top 3 champions -->
        <div id="top3_c">

            <?php for($i = 0; $i < 3; $i++) : // for loop for the top 3 champions ?>

            <!-- apply the banner depending on champion level -->
            <div class="topChamp" style="background-image: url(content/css/images/banner<?php echo $_SESSION['champMasteryArray'][$i]['championLevel'] ?>.png)">
                <div class="champIcon">
                    <img alt="<?php echo 'Level '.$_SESSION['champMasteryArray'][$i]['championLevel'] ?>" src="content/assets/champicon/<?php echo strtolower($_SESSION['champMasteryArray'][$i]['championKey']); ?>.png" />
                    <span class="champDetails">
                    <h3><?php echo $_SESSION['champMasteryArray'][$i]['championName']; ?></h3>
                    <p><?php echo $_SESSION['champMasteryArray'][$i]['championPoints']; ?> points</p>
                    </span>
                </div>
            </div>

            <?php endfor; // end top 3 loop ?>

        </div>

        <h2>All Champions</h2>
        <div class="hr_arrow"></div>
        <!-- Section holding all the user's champions - 11 at a time -->
        <div id="top11_c">
            <div class="pagination"></div>
            <table id="championTable">
                 <thead>
                     <tr>
                        <th>Champion</th>
                        <th>Level</th>
                        <th>Points</th>
                        <th>Chest</th>
                    </tr>
                </thead>
                <tbody>
            <?php foreach ($_SESSION['champMasteryArray'] as $row): // foreach that will list champion data ?>
                    <tr class="championRow">
                        <td class="championCell">
                            <img class="championAvatar" src="content/assets/champicon/<?php echo strtolower($row['championKey']); ?>.png"/>
                            <p><?php echo $row['championName']; ?></p>
                        </td>
                        
                        <td class="levelCell">
                            <img class="championLevel" src="content/assets/mastery/mastery<?php echo $row['championLevel']; ?>.png"/>
                            <p><?php echo 'Level '.$row['championLevel']; ?></p>
                        </td>
                        
                        <td class="pointsCell">
                            <p><?php echo $row['championPointsRaw']; ?></p>
                        </td>
                        
                        <td class="chestCell">
                            
                        <?php 
                          
                            if ($row['championChest'] === true){
                                $chestImage = "chest1.png";
                                $chestTitle = "Chest granted";
                            } else {
                                $chestImage = "chest0.png";
                                $chestTitle = "Chest available";
                            }
                            
                            echo '<img class="championChest" title="'.$chestTitle.'" src="content/assets/mastery/'.$chestImage.'"/>';
                        ?>
                        
                        </td>
                    </tr>      
                    
            <?php endforeach; // end foreach for table rows ?>
                    
                </tbody>
            </table>
            <div class="pagination"></div>
        </div>
        
        <!-- fixed position arrow for scrolling back to the top of the page -->
        <a title="Scroll back up the page" href="#maincontent" id="upArrow"></a>
        
        
        <?php endif; // end if statement that only displays data if enough is available ?>
</div>

</div>