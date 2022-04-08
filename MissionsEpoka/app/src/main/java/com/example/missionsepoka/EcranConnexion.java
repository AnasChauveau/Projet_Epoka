package com.example.missionsepoka;

import android.os.Bundle;
import android.view.View;
import android.widget.EditText;
import android.widget.TextView;

import androidx.appcompat.app.AppCompatActivity;

public class EcranConnexion extends AppCompatActivity {
    public static TextView tvErreur;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.ecran_de_connexion);
        tvErreur = (TextView)  findViewById(R.id.tvErreur);
    }

    public void connexion(View v) {
        EditText identifiant;
        EditText mdp;
        TextView err;

        identifiant = (EditText) findViewById(R.id.EtPseudo);
        mdp = (EditText) findViewById(R.id.EtMdp);
        err = (TextView) findViewById(R.id.tvErreur);

        GetSalarie tacheAsynchrone = new GetSalarie();
        tacheAsynchrone.urlServiceWeb = "https://zaraco-layenne.alwaysdata.net/Salarie.php?identifiant="+identifiant.getText()+"&mdp="+mdp.getText();
        tacheAsynchrone.activityApp = this;
        tacheAsynchrone.execute();

        //System.out.println(GetSalarie.msgErr);
        //err.setText(GetSalarie.msgErr);
    }
}