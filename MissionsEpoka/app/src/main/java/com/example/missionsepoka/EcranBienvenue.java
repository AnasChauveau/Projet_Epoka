package com.example.missionsepoka;


import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.os.CountDownTimer;
import android.view.View;

import java.util.Timer;

public class EcranBienvenue extends Activity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.ecran_de_bienvenue);
    }

    CountDownTimer countDownTimer = new CountDownTimer(2000,2000) {


        @Override
        public void onFinish() {
            Intent intent = new Intent(getApplicationContext(), EcranConnexion.class);
            intent.setFlags((Intent.FLAG_ACTIVITY_CLEAR_TASK+Intent.FLAG_ACTIVITY_NEW_TASK));
            startActivity(intent);
            overridePendingTransition(android.R.anim.fade_in,android.R.anim.fade_out );

        }
        @Override
        public void onTick(long milisUntilfinished) {

        }
    };
        countDownTimer.start();
}
