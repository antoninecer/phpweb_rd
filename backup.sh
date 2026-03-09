#!/usr/bin/env bash
# ============================
# backup.sh
# ============================
# Popis:
#   Vytvoří zálohu souborů z projektu podle povolených přípon.
#   Název souboru je <nazev_slozky>-<den_v_mesici>.txt
#   Přepisuje automaticky bez dotazu.
cd /opt/www/rightdone.eu/
set -euo pipefail
IFS=$'\n\t'

# 1) Nastavení cesty projektu a cílové složky
PROJECT_DIR="${1:-.}"
BACKUP_DIR="${2:-/opt/backup}"

# 2) Název složky a den
DIR_NAME="$(basename "$(realpath "$PROJECT_DIR")")"
DAY_NUM="$(date +%d)"
BACKUP_NAME="${DIR_NAME}-${DAY_NUM}.txt"
BACKUP_FILE="$BACKUP_DIR/$BACKUP_NAME"

# 3) Vytvoření výstupního souboru
mkdir -p "$BACKUP_DIR"
: > "$BACKUP_FILE"
echo "Zálohuji do: $BACKUP_FILE"

# 4) Definice
ALLOWED_DIRS=( "." "inc" "assets" )
ALLOWED_EXT=( php html csv txt css js )

echo "=== Budu zpracovávat ==="
for d in "${ALLOWED_DIRS[@]}"; do
  if [ "$d" = "." ]; then
    echo "  • Kořen projektu: $PROJECT_DIR (maxdepth 1)"
  else
    echo "  • Podadresář: $PROJECT_DIR/$d"
  fi
done
echo "Povolené přípony: ${ALLOWED_EXT[*]}"
echo

# 5) Smyčka přes adresáře
for d in "${ALLOWED_DIRS[@]}"; do
  if [ "$d" = "." ]; then
    CUR_DIR="$PROJECT_DIR"
    FIND_OPTS=( -maxdepth 1 -type f )
  else
    CUR_DIR="$PROJECT_DIR/$d"
    FIND_OPTS=( -type f )
  fi

  if [ ! -d "$CUR_DIR" ]; then
    echo "Adresář neexistuje, přeskočeno: $CUR_DIR"
    continue
  fi

  echo "Zpracovávám adresář: $CUR_DIR"

  find "$CUR_DIR" "${FIND_OPTS[@]}" | sort | while read -r FILE; do
    ext="${FILE##*.}"
    for allowed in "${ALLOWED_EXT[@]}"; do
      if [[ "${ext,,}" == "$allowed" ]]; then
        echo "  soubor: $FILE"
        REL_PATH="${FILE#$PROJECT_DIR/}"
        printf '##### BEGIN FILE: %s #####\n' "$REL_PATH" >> "$BACKUP_FILE"
        cat "$FILE" >> "$BACKUP_FILE"
        printf '\n\n' >> "$BACKUP_FILE"
        break
      fi
    done
  done
done

echo
echo "=== Hotovo: záloha uložena do $BACKUP_FILE ==="

