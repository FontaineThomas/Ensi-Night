package bdd;

public class Api_bdd {
    private static Back_end_bdd bdd = null;

    private static void create_bdd()
    {
        Api_bdd.bdd = new Back_end_bdd();
//        TODO write here code to create categories, questions and answer
//        -------------------------- VRAI / FAUX --------------------------
        Api_bdd.bdd.add_categorie("vrai/faux");
        Api_bdd.bdd.add_data("vrai/faux", "Les homosexuels sont les seules à pouvoir avoir des MST ? ", new String[]{"faux", "vrai"});
        Api_bdd.bdd.add_data("vrai/faux", "Peut-on guérir du SIDA ? ", new String[]{"faux", "vrai"});


//        -------------------------- ENFANT --------------------------
        Api_bdd.bdd.add_categorie("enfant");
        Api_bdd.bdd.add_data("enfant", "Faut-il toujours se protéger ? ", new String[]{"vrai", "faux"});
        Api_bdd.bdd.add_data("enfant", "Que veut dire MST ? ", new String[]{"Maladie Sexuellement Transmissible", "Maladie Sans Traitement", "Maladie Sexuelle Terrible", "Maladie Sexuelle Traitable"});
        Api_bdd.bdd.add_data("enfant", "Je n'ai pas pu me protéger lors d'un rapport hétérosexuel. Que dois-je faire ? ", new String[]{"Donner / prendre la pilule de lendemain et en parler", "Attender de voir ce qu'il se passe", "Chercher sur google le remède de grand mère correspondant", "Aller au toilette"});

//        -------------------------- LES DUREES --------------------------
        Api_bdd.bdd.add_categorie("les durées");
        Api_bdd.bdd.add_data("les durées", "Quelle est l'espérance de vie d'une personne ayant le SIDA ? ", new String[]{"plus de 10 à 20 ans", "- 5 ans", "de 5 à 10 ans", "de 10 à 20 ans"});
        Api_bdd.bdd.add_data("les durées", "Aujourd'hui, j'ai eu un rapport non protégé. Quand me faire dépister pour le VIH ?  ", new String[]{"Dans 4 à 12 semaines", "Aujourd'hui", "Dans les 4 semaines", "Après plus de 12 semaines"});

//        -------------------------- Contraception --------------------------
        Api_bdd.bdd.add_categorie("contraception");
        Api_bdd.bdd.add_data("contraception", "Que faire si un préservatif se déchire ?", new String[]{"Laver les muqueuses à l’eau en prenant bien soin de le pas les agresser"," retirer le préservatif détérioré et le remplacé par un autre", "Continuer l'acte", "Laver l'appareil génital avec du savon"});
        Api_bdd.bdd.add_data("contraception", "Quels sont les risques d'utiliser un préservatif usagée ?", new String[]{"Si il ne s'est pas déchiré ni glissé, il n'y a aucun risque", "Un plus grand risque d'attrapé une MST", "Avoir un risque de laisser passer des fluides pendant l'acte", "Blesser les organes génitaux des deux partenaires"});
        Api_bdd.bdd.add_data("contraception", "Quels sont les risques de ne pas déroulé le préservatif jusqu'à la base du sexe ?", new String[]{"Si l’extrémité du sexe est protégée, un homme ne prend pas de risque VIH. Au-delà, la peau constitue une barrière naturelle et efficace contre le virus", "Le préservatif devient inefficace et ne protège plus efficacement des MST", "Couper l'afflux sanguin en serrant le pénis", "Le préservatif se reprend sa forme initiale et se retire du sexe de l'homme"});


//        -------------------------- STATS --------------------------
        Api_bdd.bdd.add_categorie("stats");

    }

    private static void check_bdd()
    {
        if (Api_bdd.bdd==null)
        {
            Api_bdd.create_bdd();
        }
    }

    public static String get_question()
    {
        Api_bdd.check_bdd();
        return Api_bdd.bdd.get_question();
    }

    public static String get_question(String cat)
    {
        Api_bdd.check_bdd();
        return Api_bdd.bdd.get_question(cat);
    }

    public static String get_answer(String cat, String question)
    {
        Api_bdd.check_bdd();
        return Api_bdd.bdd.get_answer(cat, question);
    }

    public static String get_answer(String question)
    {
        Api_bdd.check_bdd();
        return Api_bdd.bdd.get_answer(question);
    }

    public static String[] get_proposition(String cat, String question)
    {
        Api_bdd.check_bdd();
        return Api_bdd.bdd.get_proposition(cat, question);
    }

    public static String[] get_proposition(String question)
    {
        Api_bdd.check_bdd();
        return Api_bdd.bdd.get_proposition(question);
    }

}
