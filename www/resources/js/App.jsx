
import './App.css';
import UrlShortener from './components/urlshortener';
import theme from './theme';
import CssBaseline from '@mui/material/CssBaseline';
import { ThemeProvider } from '@mui/material/styles';
import Container from '@mui/material/Container';
import Paper from '@mui/material/Paper';

function App() {
    return (
        <div className="App">
            <ThemeProvider theme={theme}>
                <CssBaseline />
                <Container maxWidth="md">
                    <Paper elevation={3}>
                        <UrlShortener />
                    </Paper>
                </Container>
            </ThemeProvider>
        </div>
    );
}

export default App;
