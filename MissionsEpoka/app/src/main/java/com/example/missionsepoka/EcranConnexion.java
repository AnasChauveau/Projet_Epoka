package com.example.missionsepoka;

import android.app.Activity;
import android.os.Bundle;
import android.view.View;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

public class EcranConnexion extends Activity {

    static public TextView tvResultat;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.ecran_de_connexion);

        tvResultat = (TextView)  findViewById(R.id.tvResultat);

    }

    public void Connexion() {
        super.onBackPressed();
        EditText identifiant;
        EditText motDePasse;

        identifiant = (EditText) findViewById(R.id.EtPseudo);
        motDePasse = (EditText) findViewById(R.id.EtMdp);
    }

    public void recherche(View view) {
        tvResultat.setText("Villes débutant par " + ":\n");

        TacheAsynchrone tacheAsynchrone = new TacheAsynchrone();
        tacheAsynchrone.urlServiceWeb = "https://zaraco-layenne.alwaysdata.net/Salarie.php?identifiant=marco&mdp=ggg";
        tacheAsynchrone.activityApp = this;
        tacheAsynchrone.execute();
    }


}