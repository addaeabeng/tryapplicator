<?php
if(isset($_GET['fe'])){
    $validate->force_unset();
}
?>
<style>
    select {
        background: #f7f7f7;
        background-image: -webkit-linear-gradient(rgba(255, 255, 255, 0), rgba(255, 255, 255, 0));
        border: 1px solid #d1d1d1;
        border-radius: 2px;
        color: #686868;
        padding: 0.625em 0.4375em;
        width: 100%;
    }

    .xkhsua {
        position: absolute;
        left: -999em;
    }

    .error {
        color:#ff3300;
        display: block;
    }
</style>
<p>Fields marked with (*) are required.</p>
<form action="" method="post">
    <input type="hidden" name="apsub" value="1">


    <label for="application[name]">Name*</label>
    <input type="text" name="application[name]" size="100">
    <span class="error"><?php echo $validate->display_error('name'); ?></span>

    <label for="application[email]">E-Mail</label>
    <input type="email" name="application[email]">
    <span class="error"><?php echo $validate->display_error('email'); ?></span>

    <label for="application[mobile]">Mobile</label>
    <input type="tel" name="application[mobile]">
    <span class="error"><?php echo $validate->display_error('mobile'); ?></span>

    <label for="application[instagram]">Instagram Link</label>
    <input type="text" name="application[instagram]" value="https://instagram.com/ukrap">
    <span class="error"><?php echo $validate->display_error('instagram'); ?></span>


    <label for="application[twitter]">Twitter</label>
    <input type="text" name="application[twitter]" value="https://twitter.com/ukrap">
    <span class="error"><?php echo $validate->display_error('twitter'); ?></span>

   <label for="application[instagram]">Website</label>
    <input type="text" name="application[website]" value="http://ukgrime.com">
    <span class="error"><?php echo $validate->display_error('website'); ?></span>
    <?php $locations = array(
        'London','Birmingham', 'Leeds', 'Leicester', 'Manchester', 'Glasgow', 'Edinburgh', 'Bristol', 'Norwich', 'Nottingham', 'Milton Keynes', 'Cardiff', 'Newcastle'
    ); ?>
    <label for="application[location]">Location (or select town that is nearest to you)</label>
    <select name="application[location]" id="">
        <?php foreach($locations as $l){ ?>
            <option value="<?php echo $l; ?>"><?php echo $l; ?></option>
        <?php } ?>
    </select>
    <span class="error"><?php echo $validate->display_error('location'); ?></span>
    <label for="application[skill]">Skill</label>
    <?php $skill = array('Blogging', 'Videography', 'Photography', 'Web Development', 'Graphic Design', 'Music Production'); ?>
    <select name="application[skill]" id="skill">
    <?php foreach ($skill as $s){ ?>
        <option value="<?php echo $s; ?>"><?php echo $s; ?></option>
    <?php } ?>
    </select>
    <span class="error"><?php echo $validate->display_error('skill'); ?></span>
    <label for="application[about]">Tell us a bit about you</label>
    <textarea name="application[about]" id="" cols="30" rows="10">Im very keen to get involved</textarea>
    <span class="error"><?php echo $validate->display_error('about'); ?></span>
    <label for="application[grime]">Top 5 Grime Tracks</label>
    <textarea name="application[grime]" id="" cols="30" rows="10">Im very keen to get involved</textarea>
    <span class="error"><?php echo $validate->display_error('grime'); ?></span>
    <input type="text" class="xkhsua" name="xkhusa">
    <input type="hidden" name="application[ip]" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
    <button>Apply</button>
    <?php wp_nonce_field( 'add_application_'.$post->ID); ?>
</form>