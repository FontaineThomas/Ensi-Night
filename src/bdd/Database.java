package bdd;

import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.IOException;
import java.sql.*;
import java.util.Properties;

public class Database
{
    private static Database _instance;
    private Connection connection;

    public static Database getInstance()
    {
        if (_instance == null)
            _instance = new Database();

        return _instance;
    }

    public Database()
    {
        try {
            Properties p = new Properties();
            p.load(new FileInputStream("src/main/resources/settings.properties"));

            connection = DriverManager.getConnection(
                    String.format("jdbc:%s://%s/%s", p.getProperty("db.driver"), p.getProperty("db.url"), p.getProperty("db.database")),
                    p.getProperty("db.username"), p.getProperty("db.password")
            );
        } catch (IOException | SQLException e) {
            e.printStackTrace();
        }
    }

    public Connection getConnection()
    {
        return connection;
    }

    public ResultSet query(String sql)
    {
        try {
            Statement stmt = connection.createStatement();
            ResultSet rs = stmt.executeQuery(sql);

            if (rs.next()) return rs;
            else return null;
        } catch (SQLException e) {
            e.printStackTrace();
            return null;
        }
    }

    public void update(String sql)
    {
        try {
            Statement stmt = connection.createStatement();
            stmt.executeUpdate(sql);
            stmt.close();
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }

    public Object getField(ResultSet rs, String field)
    {
        try {
            return rs.getObject(field);
        } catch (SQLException e) {
            e.printStackTrace();
            return null;
        }
    }

    public boolean hasNext(ResultSet rs)
    {
        try {
            return rs.next();
        } catch (SQLException e) {
            e.printStackTrace();
            return false;
        }
    }
}
