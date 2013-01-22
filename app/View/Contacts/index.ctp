<?php $this->Html->css('style.css', 'stylesheet', array('inline' => false)); ?>
<?php $this->Html->script('jquery-1.8.3.js', array('inline' => false)); ?>
<?php $this->Html->script('script.js', array('inline' => false)); ?>
<div id="front"><?
	echo $this->Form->create('Contact', array('action' => 'add'));
	echo $this->Form->inputs(array(
		'legend' => false,
		'id'			=> array('type' => 'hidden'),
	  'first'		=> array('type' => 'text', 'label' => 'First Name'),
	  'last'		=> array('type' => 'text', 'label' => 'Last Name'),
	  'phone'		=> array('type' => 'text', 'label' => 'Phone Number'),
	  'email'		=> array('type' => 'text', 'label' => 'Email'),
		'street'	=> array('type' => 'text', 'label' => 'Street'),
		'street2'	=> array('type' => 'text', 'label' => false),
		'zip'			=> array('type' => 'text', 'label' => 'Zip Code'),
		'Contact.country_id' => array('type' => 'select')
	));
	echo $this->Form->end('Contact');
?></div>

<div id="back">
	<ul id="contacts" class="contacts">
	<?php foreach($contacts as $contact): ?>
		<li data-id="<?php echo $contact['Contact']['id']; 
		?>" data-country="<?php echo $contact['Contact']['country_id']; 
		?>" data-city="<?php echo $contact['Contact']['city_id']; 
		?>" data-state="<?php echo $contact['Contact']['state_id']; 
		?>">
			<h2><?php echo $contact['Contact']['first']." ".$contact['Contact']['last']; ?></h2>
			<p class="address">
			<?php echo '<span class="street">'.$contact['Contact']['street'].'</span><br/>'; ?>
			<?php if(!empty($contact['Contact']['street2']))	echo '<span class="street2">'.$contact['Contact']['street2'].'</span><br/>'; ?>
			<?php if(!empty($contact['City']['city']))				echo '<span class="city">'.$contact['City']['city'].'</span>, '; ?>
			<?php if(!empty($contact['State']['state']))			echo '<span class="state">'.$contact['State']['state'].'</span>, '; ?>
			<?php if(!empty($contact['Country']['country']))	echo '<span class="country">'.$contact['Country']['country'].'</span> '; ?>
			<?php if(!empty($contact['Contact']['zip']))			echo '<span class="zip">'.$contact['Contact']['zip'].'</span>'; ?>
			</p>
			<div class="footer"><?php echo $contact['Contact']['email']." | ".$contact['Contact']['phone']; ?></div>
		</li>
	<?php endforeach; ?>	
	</ul>
	
</div>