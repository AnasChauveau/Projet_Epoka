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

    public void recherche() {
        super.onBackPressed();
        EditText identifiant;
        EditText mdp;

        identifiant = (EditText) findViewById(R.id.EtPseudo);
        mdp = (EditText) findViewById(R.id.EtMdp);
        tvResultat.setText("Bonjour : ");

        TacheAsynchrone tacheAsynchrone = new TacheAsynchrone();
        tacheAsynchrone.urlServiceWeb = "https://zaraco-layenne.alwaysdata.net/Salarie.php?identifiant="+identifiant.getText()+"&mdp="+mdp.getText();
        tacheAsynchrone.activityApp = this;
        tacheAsynchrone.execute();
    }


}