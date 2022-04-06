package com.example.missionsepoka;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.TextView;
import androidx.appcompat.app.AppCompatActivity;

public class EcranAccueil extends Activity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.ecran_de_accueil);
        TextView tvNomPrenom = findViewById(R.id.tvNomPrenom);

        tvNomPrenom.setText("Bonjour : " + GetSalarie.identite);
    }

    public void Quitter(View v){
        System.exit(0);
    }

    public void Valider(View vw){

        GetCommune tacheAsynchrone = new GetCommune();
        tacheAsynchrone.urlServiceWeb = "https://zaraco-layenne.alwaysdata.net/Commune.php";
        tacheAsynchrone.activityApp = this;
        tacheAsynchrone.execute();
    }


}