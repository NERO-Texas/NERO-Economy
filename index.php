<?php
function generateItem() {
	$weapon_types = $GLOBALS['WEAPON_TYPES'];
	$types = $GLOBALS['TYPES'];
	$schools = $GLOBALS['SCHOOLS'];
	$lengths = $GLOBALS['LENGTHS'];
    $effects = $GLOBALS['ITEMEFFECTS'];
    $weapon_only_effects = $GLOBALS['WEAPONONLYEFFECTS'];
	
    $type = array_rand($types);
    $school = array_rand($schools);
    $length = array_rand($lengths);
    $tageffects = [];	
    if($type == 'Weapon') {
        $subtype = array_rand($weapon_types);
        $tagtype = $weapon_types[$subtype];
    } else {
        $tagtype = $types[$type];
    }
    if($type == 'Weapon') {
        $i = 0;
        $k = array_rand($weapon_only_effects);
        $aura = $weapon_only_effects[$k];
        if($aura == 'Damage Aura (+1)') {
            $i += 1;
        } else if($aura == 'Damage Aura (+2)') {
            $i += 2;
        } else if($aura == 'Damage Aura (+3)') {
            $i += 3;
        }
        $tageffects[] = $aura;
        $key = array_rand($effects);
        $effect = $effects[$key];
        if($i == 1){
            //+1, we have up to 4 more effects
			generateEffects(rand(0, 4));
        } else if($i == 2) {
            //+2, we have up to 3 more effects
			generateEffects(rand(0, 3));
        } else if($i == 3) {
            //+3, we have up to 2 more effects
			generateEffects(rand(0, 2));
        }
    } else {
		$effectCount = rand(1, 5);
		generateEffects($effectCount);
	}
	foreach($GLOBALS['effs'] as $eff) {
		$tageffects[] = $eff;
	}
	
    return ['type' => $tagtype, 'school' => $schools[$school], 'length' => $lengths[$length], 'effects' => $tageffects];
	
}

function generateEffects($maxcount, $newcount = null) {
	while($GLOBALS['tpd'] < $maxcount) {
		$effs = randomSameEffect($newcount);
		$effs = array_count_values($effs);
		$key = key($effs);
		$GLOBALS['tpd'] += $effs[$key];
		$GLOBALS['effs'][] = $effs[$key].'x/Day '.$key;
		
		$newcount = $maxcount - $GLOBALS['tpd'];
		if($newcount < 0) $newcount = 0;
		generateEffects($maxcount, $newcount);
	}
}

function randomSameEffect($timesDay) {
	$uniqueEffects = rand(1, $timesDay);
	$eff = array();
	$key = rand(0, count($GLOBALS['ITEMEFFECTS']) - 1);
	for($i = 1; $i <= $uniqueEffects; $i++) {
		$eff[] = randomEffect($key);
	}
	
	return $eff;
}

function randomEffect($key = null) {
	$effects = $GLOBALS['ITEMEFFECTS'];
	if(is_null($key)) {		
		$key = array_rand($effects);
	}
	
	return $effects[$key];
}
$GLOBALS['TYPES'] = ['Weapon', 'Shield', 'Armor', 'Clothing', 'Jewelery', 'Pouch/Bag'];
$GLOBALS['WEAPON_TYPES'] = ['Bow', 'Crossbow', 'Sap', 'Bludgeon', 'Short Hammer', 'Long Hammer', 'Short Mace', 'Long Mace', 'Dagger', 'Hatchet', 'Short Sword', 'Long Sword', 'Short Axe', 'Long Axe', 'One Handed Spear', 'Two Handed Axe', 'Halberd/Polearm', 'Staff', 'Thrown Weapon', 'Two Handed Blunt', 'Two Handed Sword', 'Javelin'];
$GLOBALS['SCHOOLS'] = ['Celestial', 'Earth'];
$GLOBALS['LENGTHS'] = ['6 Months', '1 Year', '2 Years'];
$GLOBALS['WEAPONONLYEFFECTS'] = ['Damage Aura (+1)', 'Damage Aura (+2)', 'Damage Aura (+3)'];
$GLOBALS['ITEMEFFECTS'] = ['Cloak, Binding', 'Cloak, Chaos', 'Cloak, Charm', 'Cloak, Command', 'Cloak, Curse', 'Cloak, Earth', 'Cloak, Fire',	'Cloak, Call Forth', 'Cloak, Ice', 'Cloak, Lightning', 'Cloak, Stone', 'Cloak, Summoned Force', 'Bane, Binding', 'Bane, Chaos',	'Bane, Charm', 'Bane, Command', 'Bane, Curse', 'Bane, Earth', 'Bane, Fire', 'Bane, Call Forth', 'Bane, Ice', 'Bane, Lightning', 'Bane, Stone',	'Bane, Summoned Force', 'Exp. Enchant, Awaken',	'Exp. Enchant, Circle of Power', 'Exp. Enchant, Cure Mortal Wounds', 'Exp. Enchant, Death', 'Exp. Enchant, Dragon\'s Breath', 'Exp. Enchant, Imprison', 'Exp. Enchant, Inspiration', 'Exp. Enchant, Life', 'Exp. Enchant, Ward'];
$GLOBALS['effs'] = array();
$GLOBALS['tpd'] = 0;

$item = generateItem();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Basic Page Needs
    ================================================== -->
    <meta charset="utf-8" />
    <title>
        NERO LARP Economy
    </title>
    <!-- Mobile Specific Metas
    ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS
    ================================================== -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>

<body>
<!-- To make sticky footer need to wrap in a div -->
<div id="wrap">

    <!-- Container -->
    <div class="container">
        <!-- Content -->
        <div class="row">
			<?php if(!isset($_COOKIE['chapter'])):?>
			<div class="col-md-8">
                <!-- Post Title -->
                <div class="row">
                    <div class="col-md-8">
                        <h4><strong>Please select the NERO chapter you play MOST at:</strong></h4>
                        <div id="form_chapter" class="form-group">
							<form>
							<label class="control-label" for="chapter">Chapter:</label>
							<select required autofocus class="form-control" id="chapter" name="chapter">
								<option value="">--</option>
								<option value="ARGO FLAG">ARGO FLAG</option>
								<option value="Armonia">Armonia</option>
								<option value="Atlanta">Atlanta</option>
								<option value="BANE">BANE</option>
								<option value="Boston">Boston</option>
								<option value="Central Phoenix">Central Phoenix</option>
								<option value="Chronicles">Chronicles</option>
								<option value="Dragonaire">Dragonaire</option>
								<option value="Empire">Empire</option>
								<option value="Grand Rapids">Grand Rapids</option>
								<option value="Hartford">Hartford</option>
								<option value="Highborn">Highborn</option>
								<option value="Indiana">Indiana</option>
								<option value="Kalamazoo">Kalamazoo</option>
								<option value="Kentucky">Kentucky</option>
								<option value="Labyrinth">Labyrinth</option>
								<option value="Las Vegas">Las Vegas</option>
								<option value="Legends">Legends</option>
								<option value="Lost Realms">Lost Realms</option>
								<option value="Maritimes">Maritimes</option>
								<option value="Mass">Mass</option>
								<option value="Nebraska">Nebraska</option>
								<option value="Odyssey">Odyssey</option>
								<option value="Piedmont">Piedmont</option>
								<option value="PRO">PRO</option>
								<option value="South Carolina">South Carolina</option>
								<option value="Southern New England">Southern New England</option>
								<option value="Southern Ohio">Southern Ohio</option>
								<option value="Southern West Virginia">Southern West Virginia</option>
								<option value="SWAG">SWAG</option>
								<option value="Texas">Texas</option>
							</select>
							<br />
							<button id="submit_chapter" type="button" class="btn btn-success">Submit</button>
							</form>
						</div>
                    </div>
                </div>
                <!-- ./ post title -->
			</div>
			<?php else: ?>
			
            <div class="col-md-8">
                <!-- Post Title -->
                <div class="row">
                    <div class="col-md-8">
                        <h4><strong>How Much Would This Item be Worth?</strong></h4>
                        <p>All items are non spirit linked or spirit locked.</p>
                        <p>All items are rendered.</p>
                    </div>
                </div>
                <!-- ./ post title -->

                <!-- Post Content -->
                <div class="row">
                    <div class="col-md-8">
                        School: <strong><?php echo $item['school']; ?></strong><br />
                        Item Type: <strong><?php echo $item['type']; ?></strong>,<br />
                        Duration <strong><?php echo $item['length']; ?></strong>,<br >
                        <ul>
                            <?php foreach($item['effects'] as $effect) { ?>
                            <li><?php echo $effect; ?></li>
                            <?php } ?>
                        </ul>

                        <hr />												
						<div id="form" class="form-group">
							<form>
							<label class="control-label" for="gold">Approximate Value in <strong>SILVER</strong> At NERO <?php echo $_COOKIE['chapter']; ?>:</label><input required autofocus min="0" class="form-control" type="number" id="silver" name="silver" required><br />
							<div id="moneycalc" style="display: none;">
								<p>The silver you entered is equal to <span id="calc_value_gold" style="font-weight: bold;"></span>.
							</div>
							<button id="submit" type="button" class="btn btn-success">Submit</button>
							</form>
						</div>						
                        <hr />
                    </div>
                </div>
                <!-- ./ post content -->
            </div>
			<?php endif; ?>
        </div>
        <!-- ./ content -->
    </div>
    <!-- ./ container -->

    <!-- the following div is needed to make a sticky footer -->
    <div id="push"></div>
</div>
<!-- ./wrap -->

<div id="footer">
    <div class="container">
		<p>
			Please direct any questions to Keaton Mantz via email by <a href="mailto:&#107;&#101;&#097;&#116;&#111;&#110;&#100;&#109;&#064;&#103;&#109;&#097;&#105;&#108;&#046;&#099;&#111;&#109;">clicking here</a>.
		</p>
		<?php if(isset($_COOKIE['chapter'])):?>
		<a href="unset_chapter.php">Change Chapter</a>
		<?php endif; ?>
    </div>
</div>

<!-- Javascripts
================================================== -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script>
	$('#silver').change(function() {
		var orig_silver = $('#silver').val();
		if(orig_silver != '') {
			$('#moneycalc').show();
		} else {
			$('#moneycalc').hide();
		}
		
		var newgold = Math.trunc(orig_silver / 10);
		var newmoney = orig_silver % 10;
		var newsilver = Math.trunc(newmoney % 10);
		
		$('#calc_value_gold').html(newgold+" Gold, "+newsilver+" Silver");
	});

    $('#submit').click( function( e ) {
        e.preventDefault();
        var silver = $('#silver').val();
        var item = JSON.stringify(<?php echo json_encode($item); ?>);
        if(silver == '') {
            $('#form').addClass('has-error');
            return false;
        }

        $.ajax({
            'async': true,
            'type': "POST",
            'global': false,
            'dataType': 'html',
            'url': 'save.php',
            'data': { item: item, silver: silver },
            'success': function (data) {
                window.location.reload();
            }
        });
    });
	
	$('#submit_chapter').click( function( e ) {
        e.preventDefault();
        var chapter = $('#chapter').val();
        if(chapter == '') {
            $('#form_chapter').addClass('has-error');
            return false;
        }

        $.ajax({
            'async': true,
            'type': "POST",
            'global': false,
            'dataType': 'html',
            'url': 'save_chapter.php',
            'data': { chapter: chapter },
            'success': function (data) {
                window.location.reload();
            }
        });
    });
</script>
</body>
</html>
