package space_invador;

public class Level {
    private Ennemy[][] ennemies;
    private int ligne_haut_gauche;
    private int colonne_haut_gauche;
    private int ligne_haut_gauche_max;
    private int colonne_haut_gauche_max;

    public Level(int niveau, int l1, int l2, int l3, int l4, int l5)
    {
        this.ennemies = new Ennemy[5][11]; // 5 lignes et 11 colonnes
        this.ligne_haut_gauche = 0;
        this.colonne_haut_gauche = 0;
        for (int i=0; i<11; i++)
        {
            this.ennemies[0][i] = new Ennemy(l5, 100*niveau);
            this.ennemies[1][i] = new Ennemy(l4, 100*niveau);
            this.ennemies[2][i] = new Ennemy(l3, 100*niveau);
            this.ennemies[3][i] = new Ennemy(l2, 100*niveau);
            this.ennemies[4][i] = new Ennemy(l1, 100*niveau);
        }
    }

    public void display()
    {
        for (Ennemy[] es : this.ennemies)
        {
            for (Ennemy e: es)
            {
                e.display();
            }
        }
    }

    public void actualise()
    {

    }
}
