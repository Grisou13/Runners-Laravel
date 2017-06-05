{{ Form::bsText("Prenom","firstname", $user->firstname) }}
{{ Form::bsText("Nom","lastname", $user->lastname) }}
{{ Form::bsText("Email","email", $user->email) }}
{{ Form::bsText("Nom abbrégé","name", $user->name) }}
{{ Form::bsText("Téléphone","phone", $user->phone) }}
<div class="form-group">
    <label for="sex" class="col-md-4 control-label">Sexe </label>
    <div class="col-md-6">
        <select id="sex" name="sex" class="form-control">
            <option {{ (int)old("sex",$user->sex) == 0 ? "selected" : null }} value="0">Female</option>
            <option {{ (int)old("sex",$user->sex) == 1 ? "selected" : null}}value="1">Male</option>
        </select>
    </div>
</div>