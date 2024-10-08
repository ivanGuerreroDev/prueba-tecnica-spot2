import { useState, useEffect } from 'react';
import UrlList from './urlList';
import { Box } from '@mui/material';
import TextField from '@mui/material/TextField';
import Button from '@mui/material/Button';
import CircularProgress from '@mui/material/CircularProgress';

function UrlShortener() {
    const [url, setUrl] = useState('');
    const [csrfToken, setCsrfToken] = useState('');
    const [urlList, setUrlList] = useState([]);
    const [fetching, setFetching] = useState(false);
    const [creating, setCreating] = useState(false);

    useEffect(() => {
        const tokenElement = document.querySelector('meta[name="csrf-token"]');
        if (tokenElement) {
            const token = tokenElement.getAttribute('content');
            setCsrfToken(token);
        } else {
            console.error('Token CSRF no encontrado');
        }
    }, []);

    useEffect(() => {
        if(csrfToken !== '') {
            getUrlShorteneds();
        }
    }, [csrfToken]);

    const getUrlShorteneds = async () => {
        setFetching(true);
        const response = await fetch('http://localhost:8000/api/url', {
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken, // Añadir token CSRF
            },
        });
        const data = await response.json();
        setUrlList(data);
        setFetching(false);
    }
    const removeUrlShortened = async (id) => {
        const response = await fetch(`http://localhost:8000/api/url/${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken, // Añadir token CSRF
            },
        });
        if (response.ok) {
            getUrlShorteneds();
        }
    }
    const handleSubmit = async (e) => {
        e.preventDefault();
        setCreating(true);
        const response = await fetch('http://localhost:8000/api/url/shorten', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken, // Añadir token CSRF
            },
            body: JSON.stringify({ url }),
        });
        await response.json();
        setCreating(false);
        setUrl('');
        getUrlShorteneds();
    };

    return (
        <div>
            <h1>URL Shortener</h1>
            <Box
                component="form"
                sx={{
                    padding: '20px',
                    border: '1px solid #ccc',
                    borderRadius: '5px',
                    marginBottom: '20px',
                    display: 'flex',
                    gap: '10px',
                    alignItems: 'center',
                }}
                autoComplete="off"
                onSubmit={handleSubmit}
            >
                <TextField
                    fullWidth
                    id="url"
                    label="Enter a URL"
                    variant="outlined"
                    value={url}
                    onChange={(e) => setUrl(e.target.value)}
                    required
                />
                <Button variant="contained" type="submit" disabled={creating}>
                    Shorten {creating && <CircularProgress size={20} />}
                </Button>
            </Box>
            <UrlList
                data={urlList}
                onRemove={removeUrlShortened}
                loading={fetching}
            />

        </div>
    );
}

export default UrlShortener;
