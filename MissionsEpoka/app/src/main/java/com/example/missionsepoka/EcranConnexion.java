package com.example.missionsepoka;

import android.os.Bundle;
import android.view.View;
import android.widget.EditText;
import android.widget.TextView;
import androidx.appcompat.app.AppCompatActivity;

public class EcranConnexion extends AppCompatActivity {

    static public TextView tvResultat;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.ecran_de_connexion);

        tvResultat = (TextView)  findViewById(R.id.tvResultat);

    }

    public void connexion(View v) {
        EditText identifiant;
        EditText mdp;

        identifiant = (EditText) findViewById(R.id.EtPseudo);
        mdp = (EditText) findViewById(R.id.EtMdp);
        tvResultat.setText("");

        TacheAsynchrone tacheAsynchrone = new TacheAsynchrone();
        tacheAsynchrone.urlServiceWeb = "https://zaraco-layenne.alwaysdata.net/Salarie.php?identifiant="+identifiant.getText()+"&mdp="+mdp.getText();
        tacheAsynchrone.activityApp = this;
        tacheAsynchrone.execute();
    }


}