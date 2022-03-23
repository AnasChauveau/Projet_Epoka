package com.example.missionsepoka;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.EditText;
import android.widget.TextView;
import androidx.appcompat.app.AppCompatActivity;

public class EcranAccueil extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.ecran_de_accueil);
        TextView tvNomPrenom = findViewById(R.id.tvNomPrenom);
        String identite = getIntent().getStringExtra(TacheAsynchrone.EXTRA_MESSAGE);

        tvNomPrenom.setText("Bonjour : " + TacheAsynchrone.EXTRA_MESSAGE);
    }


}