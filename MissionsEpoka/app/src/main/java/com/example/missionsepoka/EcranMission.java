package com.example.missionsepoka;


import android.app.Activity;
import android.app.Dialog;
import android.graphics.Color;
import android.graphics.drawable.ColorDrawable;
import android.os.Bundle;
import android.text.Editable;
import android.text.TextWatcher;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.EditText;
import android.widget.ListView;
import android.widget.TextView;

public class EcranMission extends Activity {

    TextView textView;
    Dialog dialog;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.ecran_ajout_mission);

        textView = findViewById(R.id.tvRecherche);

        textView.setOnClickListener(new View.OnClickListener(){
            @Override
            public  void onClick(View b){

                dialog = new Dialog(EcranMission.this);
                dialog.setContentView(R.layout.dialog_searchable_spinner);
                dialog.getWindow().setLayout(650, 800);
                dialog.getWindow().setBackgroundDrawable(new ColorDrawable(Color.TRANSPARENT));
                dialog.show();

                EditText etRecherche = dialog.findViewById(R.id.etRecherche);
                ListView listeCommune = dialog.findViewById(R.id.listeCommune);

                ArrayAdapter<String> adapter = new ArrayAdapter<>(EcranMission.this,
                        android.R.layout.simple_list_item_1,GetCommune.Commune);
                listeCommune.setAdapter(adapter);
                etRecherche.addTextChangedListener(new TextWatcher() {
                    @Override
                    public void beforeTextChanged(CharSequence charSequence, int i, int i1, int i2) {

                    }

                    @Override
                    public void onTextChanged(CharSequence charSequence, int i, int i1, int i2) {
                        adapter.getFilter().filter((charSequence));
                    }

                    @Override
                    public void afterTextChanged(Editable editable) {

                    }
                });

                listeCommune.setOnItemClickListener(new AdapterView.OnItemClickListener() {
                    @Override
                    public void onItemClick(AdapterView<?> adapterView, View view, int i, long l) {
                        textView.setText(adapter.getItem(i));
                        dialog.dismiss();
                    }
                });
            }
        });
    }

    public void Envoyer(View v){
        EditText dateDebut;
        EditText dateFin;
        TextView commune;
        String identifiant;

        dateDebut = (EditText) findViewById(R.id.etDateDebut);
        dateFin = (EditText) findViewById(R.id.etDateFin);
        commune = (TextView) findViewById(R.id.tvRecherche);
        BDD.Salarie salarie = new BDD.Salarie();
        identifiant = salarie.getIdentite();

        PostMission tacheAsynchrone = new PostMission();
        tacheAsynchrone.urlServiceWeb = "https://zaraco-layenne.alwaysdata.net/Ajout_mission.php";
        tacheAsynchrone.postData = "dateDebut=" + dateDebut.getText() + "dateFin=" + dateFin.getText() + "identifiant=" + identifiant + "idCommune=" + commune.getText();
        tacheAsynchrone.activityApp = this;
        tacheAsynchrone.execute();
    }
}