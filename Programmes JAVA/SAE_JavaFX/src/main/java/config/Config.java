package config;

import com.fasterxml.jackson.annotation.JsonProperty;
import com.fasterxml.jackson.databind.ObjectMapper;
import com.fasterxml.jackson.dataformat.yaml.YAMLFactory;

import java.io.IOException;
import java.nio.charset.StandardCharsets;
import java.nio.file.Files;
import java.nio.file.Paths;

public class Config
{
    public class SeuilMax
    {
        @JsonProperty
        public int C02;

        @JsonProperty
        public int Temp;

        @JsonProperty
        public int Hum;
    }

    @JsonProperty
    public SeuilMax seuilMax;

    public static Config parseFile(String file)
    {
        final ObjectMapper mapper = new ObjectMapper(new YAMLFactory());

        try
        {
            final String yamlSource = new String(Files.readAllBytes(Paths.get(file)), StandardCharsets.UTF_8);

            return mapper.readValue(yamlSource, Config.class);
        }
        catch (IOException e)
        {
            e.printStackTrace();
        }

        return null;
    }
}
