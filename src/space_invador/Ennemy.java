package space_invador;

public class Ennemy {
    protected int image;
    protected int life;
    protected boolean animation_destroy;

    public Ennemy(int image, int life)
    {
        this.image = image;
        this.life = life;
        this.animation_destroy = false;
    }

    public void damage(int dmg)
    {
        this.life -= dmg;
        if (this.life < 0)
        {
            this.animation_destroy = true;
        }
    }

    public void display() {
//        TODO a faire
    }
}
