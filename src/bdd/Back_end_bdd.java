package bdd;

import java.util.HashMap;
import java.util.Random;

public class Back_end_bdd {
    private HashMap<String, HashMap<String, String[]>> data;

    protected Back_end_bdd()
    {
        this.data = new HashMap<>();
    }

    protected void add_categorie(String cat)
    {
        this.data.put(cat, new HashMap<>());
    }

    protected void add_data(String cat, String question, String[] propositions)
    {
        if (!this.data.containsKey(cat))
            this.add_categorie(cat);
        this.data.get(cat).put(question, propositions);
    }

    protected String get_question()
    {
        Random generator = new Random();
        Object[] values = this.data.keySet().toArray();
        String random_key = (String)values[generator.nextInt(values.length)];
        return this.get_question(random_key);
    }

    protected String get_question(String cat)
    {
        Random generator = new Random();
        HashMap<String, String[]> categorie = this.data.get(cat);
        Object[] values_data = categorie.keySet().toArray();
        return (String)values_data[generator.nextInt(values_data.length)];
    }

    protected String get_answer(String cat, String question)
    {
        if (this.data.containsKey(cat))
            return this.data.get(cat).get(question)[0];
        return null;
    }

    protected String get_answer(String question)
    {
        for (String cat: this.data.keySet())
        {
            if (this.get_answer(cat, question)!=null)
            {
                return this.get_answer(cat, question);
            }
        }
        return null;
    }

    protected String[] get_proposition(String cat, String question)
    {
        if (this.data.containsKey(cat))
            return this.data.get(cat).get(question);
        return null;
    }

    protected String[] get_proposition(String question)
    {
        for (String cat: this.data.keySet())
        {
            if (this.get_proposition(cat, question)!=null)
            {
                return this.get_proposition(cat, question);
            }
        }
        return null;
    }

}
